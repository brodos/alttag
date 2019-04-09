<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Url extends Model
{
    use Notifiable;
    

    public $guarded = [];

    public $dates = ['crawled_at'];

    public $casts = [
        'meta_data' => 'array',
    ];

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    // Site relationship
    public function site()
    {
    	return $this->belongsTo(Site::class);
    }

    // Parent URL relationship
    public function parent()
    {
        return $this->belongsTo(Url::class, 'parent_url_id');
    }

    // Children URLs relationship
    public function children()
    {
        return $this->hasMany(Url::class, 'parent_url_id');
    }

    // Images relationship
    public function images()
    {
    	return $this->hasMany(Image::class);
    }
}
