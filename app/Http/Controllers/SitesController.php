<?php

namespace App\Http\Controllers;

use App\Site;
use Goutte\Client;
use App\Jobs\CrawlUrlJob;
use App\Jobs\UrlCrawlerJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = auth()->user()->sites()->latest()->get();
        $sites->load('urls','images');

        return view('sites.index', compact('sites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the input
        $attributes = request()->validate([
            'display_name'  => 'required|min:1|max:255',
            'url'           => 'required|active_url',
            'crawl'         => 'required|in:1,2',
            'process'       => 'required|in:1,2',
        ]);

        // add some custom attributes
        $attributes['domain'] = str_replace('www.', '', parse_url($attributes['url'], PHP_URL_HOST));
        $attributes['slug'] = str_slug($attributes['display_name']);
        $attributes['url_hash'] = md5($attributes['url']);
        $attributes['uuid'] = Str::uuid();

        // add the site
        $site = auth()->user()->sites()->create($attributes);

        // add the site url as the first url to be crawled
        $url = $site->urls()->create([
            'url' => $site->url,
            'url_hash' => md5($site->url),
        ]);

        // dispatch a crawl job
        CrawlUrlJob::dispatch($url)->onQueue('fast-url-crawl');
        
        return redirect()->route('user-sites.show', $site);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Url  $urls
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        $this->authorize('manage', [$site, auth()->user()]);

        $site->load('urls','images');

        return view('sites.show', compact('site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        $this->authorize('manage', $site);

        $site->delete();

        return response([], 204);
    }
}
