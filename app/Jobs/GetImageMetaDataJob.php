<?php

namespace App\Jobs;

use App\Image;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetImageMetaDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $image;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $meta = $this->image->getMetaData();

        $this->image->meta_data = $meta;
        $this->image->status_code = $meta['status_code'];
        $this->image->processed_at = now();

        $this->image->save();

        return $this->image;
    }

    public function failed(Exception $exception)
    {
        Log::debug($exception->getMessage());
    }
}
