<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($slug)
    {
        return auth()->user()->sites()->where('slug', $slug)->first() ?? abort(404);
    }

    public function getCanonicalUrl($url = null) 
    {
        if (! $url) {
            $url = $this->url;
        }

        $headers = get_headers($url, 1);

        if (isset($headers['Location'])) {
            return $this->getCanonicalUrl($headers['Location']);
        }

        $this->canonical_url = $url;
        $this->save();

        return $url;
    }

    // Owner relationship
    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    // URLs relationship
    public function urls()
    {
    	return $this->hasMany(Url::class)->oldest()->limit(30);
    }

    // Images relationship
    public function images()
    {
    	return $this->hasMany(Image::class)->oldest()->limit(30);
    }
}
