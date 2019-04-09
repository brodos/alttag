<?php

namespace App\Services;

use App\Image;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class Vision {

	protected $image;
	protected $headers;
	protected $queryParams;
	protected $body;
	protected const ENDPOINT = 'https://westeurope.api.cognitive.microsoft.com/vision/v2.0';
	protected const APIKEY = 'cdae3ac0c10a43cf9cb3376cf68a775b';
	
	public function __construct() 
	{
	}

	public function getData(Image $image)
	{
		$this->setImage($image);
		$this->setHeaders();
		$this->setBody();

		$full_url = $this->buildRequestUrl();
		$payload = $this->buildPayload();

		$api = new Client();

		// dd(get_class_methods(ClientException::class));
		// dd($payload);
		try {
			$response = $api->request('POST', $full_url, $payload);

			$this->response = json_decode($response->getBody(), true);
		} catch (ClientException $e) {
			$this->response['error'] = json_decode($e->getResponse()->getBody(), true);
		}

		return $this;
	}

	public function getTags()
	{
		return $this->response['description']['tags'] ?? $this->response['error'] ?? [];
	}

	public function getCaptions()
	{
		return $this->response['description']['captions'] ?? $this->response['error'] ?? [];
	}

	public function getFirstCaption()
	{
		return $this->response['description']['captions'][0] ?? $this->response['error'] ?? [];
	}

	public function getMeta()
	{
		return $this->response['metadata'] ?? $this->response['error'] ?? [];
	}

	protected function buildPayload()
	{
		$payload = [];

		if (!empty($this->headers) && is_array($this->headers)) {
			$payload['headers'] = $this->headers;
		}

		if (!empty($this->body) && is_array($this->body)) {
			$payload['json'] = $this->body;
		}

		return $payload;
	}

	protected function buildRequestUrl()
	{
		return self::ENDPOINT . '/analyze?visualFeatures=Description'; 
	}

	protected function setImage(Image $image)
	{
		$this->image = $image;
	}

	protected function setHeaders() 
	{
		$this->headers = [
			'Content-Type' => 'application/json',
			'Ocp-Apim-Subscription-Key' => self::APIKEY,
		];

		return $this;
	}

	protected function setBody()
	{
		$this->body = [
			'url' => $this->image->image_url,
		];

		return $this;
	}

}