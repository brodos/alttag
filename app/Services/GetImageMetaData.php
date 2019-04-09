<?php

namespace App\Services;

use App\Image;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\ConnectException;
use Intervention\Image\Facades\Image as Intervention;
use Intervention\Image\Exception\NotReadableException;

class GetImageMetaData {
	
	protected $image;

	public function __construct(Image $image) 
	{
		$this->image = $image;
	}

	public function getMetaData()
	{
		$meta = [];

		$headers = $this->getHeaders($this->image->url);
		$meta['status_code'] = (int) explode(' ', $headers[0])[1];

		$image = $this->makeInterventionImage();

		if (! $image) {
			return $meta;
		}

		$meta['width'] = $image->width();
		$meta['height'] = $image->height();
		$meta['filesize'] = isset($headers['Content-Length']) ? $headers['Content-Length'] : $image->filesize();
		$meta['mime'] = $image->mime();
		$meta['exif'] = $image->exif();
		$meta['iptc'] = $image->iptc();

		return $meta;
	}

	private function getHeaders($url) {
		$headers = get_headers($url, 1);

		if (isset($headers['Location'])) {

			$this->image->url = $headers['Location'];

			return $this->getHeaders($headers['Location']);
		}

		return $headers;
	}

	private function makeInterventionImage()
	{
		try {
			$image = Intervention::make($this->image->url);
		} catch(NotReadableException $e) {
			$image = null;
		}
		
		return $image;
	}

}