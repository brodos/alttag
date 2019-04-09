<?php

namespace App\Http\Controllers;

use App\Url;
use App\Site;
use App\Image;
use App\Service\Crawler;
use GuzzleHttp\Psr7\Uri;
use App\Jobs\CrawlUrlJob;
use Illuminate\Http\Request;
use App\Notifications\CrawlUrlFailedNotification;

class CrawlController extends Controller
{
    public function crawl(Site $site, Url $url)
    {

        // init the crawler and put it to work
        $crawler = (new Crawler($url))->crawlUrl();

        // lets get the found data
        $foundUrls = $crawler->getFoundUrls();
        $foundImages = $crawler->getFoundImages();
        $response = $crawler->getResponse();
        $meta = $crawler->getMetaData();

        dd($foundImages);


    	dd($crawler);
    }


    public function crawlNow(Site $site, Url $url)
    {
    	$result = CrawlUrlJob::dispatchNow($url, true);

    	dd($result);
    }
}
