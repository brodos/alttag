<?php

namespace App\Http\Controllers;

use App\Url;
use App\Site;
use Illuminate\Http\Request;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $site->load('urls.parent','urls.images','urls.children');

        return view('sites.urls.index', compact('site'));
    }

    /**
     * Display the specified resource.
     *
     * @param  $site App\Site
     * @param  $url App\Url
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Url $url)
    {
        $url->load('parent','images','children');

        return view('sites.urls.show', compact('site','url'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
