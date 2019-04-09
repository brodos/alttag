<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Site::class, function (Faker $faker) {
	$url = $faker->url;
	$domain = str_replace('www.', '', parse_url($url, PHP_URL_HOST));
    $display_name = $faker->company;

    return [
    	'user_id' => factory('App\User'),
        'url' => $url,
    	'url_hash' => md5($url),
        'domain' => $domain,
        'slug' => Str::slug($display_name),
        'display_name' => $display_name,
        'crawl' => 1,
        'process' => 1,
    ];
});
