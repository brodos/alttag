<?php

namespace App;

use App\Services\GetImageMetaData;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $guarded = [];

    protected $casts = [
    	'meta_data' => 'array',
    	'vision_api_data' => 'array',
    ];

    public function found_on()
    {
    	return $this->belongsTo(Url::class, 'url_id');
    }

    public function site()
    {
    	return $this->belongsTo(Site::class);
    }

    public function getMetaData()
    {
    	return (new GetImageMetaData($this))->getMetaData();
    }
}
