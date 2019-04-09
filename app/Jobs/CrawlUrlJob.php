<?php

namespace App\Jobs;

use App\Url;
use App\Site;
use App\Image;
use Exception;
use App\Service\Crawler;
use Illuminate\Bus\Queueable;
use App\Jobs\GetImageMetaDataJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\CrawlUrlFailedNotification;

class CrawlUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The URL to be crawled
     * @var App\Url
     */
    protected $url;

    /**
     * The main Site this url belongs to
     * @var App\Site
     */
    protected $site;
    /**
     * Force a new recrawl
     * @var App\Site
     */
    protected $force;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Url $url, $force = false)
    {
        $this->url = $url;
        $this->site = $url->site;
        $this->force = $force;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // check if not already crawled or queued by another qorker
        if (($this->url->crawled_at !== null) && $this->force === false) {
            return 'already crawled';
        }

        // fetch the main site canonical url
        if (! $this->site->canonical_url) {
            $this->site->getCanonicalUrl();
        }

        // init the crawler and put it to work
        $crawler = (new Crawler($this->url))->crawlUrl();

        // lets get the found data
        $foundUrls = $crawler->getFoundUrls();
        $foundImages = $crawler->getFoundImages();
        $response = $crawler->getResponse();
        $meta = $crawler->getMetaData();

        // check for found images and persist them
        if ($foundImages->isNotEmpty()) {
            $this->url->images()->saveMany($foundImages->map(function($image) {
                return new Image([
                    'site_id' => $this->site->id,
                    'url' => $image['url'],
                    'url_hash' => md5($image['url']),
                    'alt' => $image['alt'],
                ]);
            }))->each(function(Image $image) {
                // Dispatch jobs to fetch images meta data
                GetImageMetaDataJob::dispatch($image)->onQueue('image-metadata');
            });
            

            if ($this->site->process == 2 && $this->force === false) {
                // dispatch Image processing by the API
                
            }
        }

        // check for found URLs and persist them, then dispatch new Jobs for each one
        if ($foundUrls->isNotEmpty()) {
            $this->site->urls()->saveMany($foundUrls->map(function($url) {
                return new Url([
                    'parent_url_id' => $this->url->id,
                    'url' => $url,
                    'url_hash' => md5($url),
                ]);
            }))->each(function(Url $newUrl) {
                // if site is set to go down the rabbit hole, then continue crawling
                if ($this->site->crawl == 2 && $this->force === false) {
                    CrawlUrlJob::dispatch($newUrl)->onQueue('normal-url-crawl');
                }
            });
        }

        // set crawled_at attribute
        $attributes = [
            'crawled_at' => now(),
        ];

        // set response attributes
        if ($response !== null) {
            $attributes['status_code'] = $response->getStatus();
            $attributes['page_size'] = $response->getHeaders()['Content-Length'][0] ?? 0;
            $attributes['page_title'] = $meta['page:title'] ?? null;
            $attributes['meta_data'] = $meta;
        }

        // update the url data
        $this->url->update($attributes);

        return $this->url->refresh();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        Log::debug($exception->getMessage());

        return $this->url->notify(new CrawlUrlFailedNotification($this->url, $e->getMessage()));
    }
}
