<?php

namespace App\Http\Controllers;

use App\Site;
use App\Image;
use App\Services\Vision;
use App\Services\HumanSize;
use Illuminate\Http\Request;
use App\Jobs\GetImageMetaDataJob;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Site $site)
    {
        $site->load('images.found_on','urls');

        return view('sites.images.index', compact('site'));
    }

    private function getHeaders($url) {
        $headers = get_headers($url, 1);

        if (isset($headers['Location'])) {
            return $this->getHeaders($headers['Location']);
        }

        return $headers;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site, Image $image)
    {

        // GetImageMetaDataJob::dispatchNow($image);
        // $headers = $this->getHeaders($image->url);


        // dd($headers);

        return view('sites.images.show', compact('site','image'));
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
