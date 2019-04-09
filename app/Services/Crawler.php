<?php

namespace App\Service;

use App\Url;
use App\Site;
use App\Image;
use Goutte\Client;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Component\BrowserKit\Response;


class Crawler {

	/**
	 * The URL that we're trying to crawl
	 * @var object App\Url
	 */
	protected $url;
	/**
	 * The Site
	 * @var object App\Site
	 */
	protected $site;
	/**
	 * The normalized URL
	 * @var string
	 */
	protected $normalizedUrl;
	/**
	 * Url Meta data
	 * @var Illuminate\Support\Collection
	 */
	protected $metaData;
	/**
	 * Normalized domain name
	 * @var string
	 */
	protected $domain;
	/**
	 * Found URLs on the scraped URL
	 * @var Illuminate\Support\Collection
	 */
	protected $foundUrls;
	/**
	 * Found Images on the scraped URL
	 * @var Illuminate\Support\Collection
	 */
	protected $foundImages;
	/**
	 * Existing URLs for the parent Site
	 * @var Illuminate\Support\Collection
	 */
	protected $existingUrls;
	/**
	 * Existing Images for the parent site
	 * @var Illuminate\Support\Collection
	 */
	protected $existingImages;

	/**
	 * Excluded URLs
	 * @var array
	 */
	protected $excluded;
	/**
	 * Allowed image extensions
	 * @var array
	 */
	protected $allowedImageExtensions;
	/**
	 * Guzzle Client Response for the request
	 * @var Guzzle\Response
	 */
	protected $response;
	/**
	 * The Symfony DomCrawler instance
	 * @var Symfony\DomCrawler\Crawler
	 */
	protected $_crawler;

	function __construct(Url $url)
	{
		$this->url = $url;

		$this->site = $url->site;

		// fetch exiting URLs and map them to the existing urls collection
		$this->existingUrls = $this->site->urls->pluck('url', 'url_hash');
		
		// fetch exiting URLs and map them to the existing urls collection
		$this->existingImages = $this->site->images->pluck('image_url', 'image_hash');

		$this->metaData = collect();
		$this->foundUrls = collect();
		$this->foundImages = collect();

		// normalize the to be crawled url
		$this->normalizedUrl = $this->normalizeUrl($url->url);

		// get the domain name for the crawled url - used to dismiss urls that fall outside of this domain
		$this->domain = $this->getDomain($this->normalizedUrl);

		// init the excluded urls masks array
		$this->excluded = ['#','.pdf','.js','.css','.mp3','.mp4','.mpeg','.zip','.gzip','.tar','.flv','.txt','.ico','.tgz','.avi','.mpeg','mailto:','tel:'];

		// init the allowed image extenstions array
		$this->allowedImageExtensions = ['jpeg','jpg','png','gif','bmp'];
	}

	/**
	 * Start crawling the given URL
	 * 
	 * @return self
	 */
	public function crawlUrl()
	{
		$client = new Client();

		try {
	        $this->_crawler = $client->request('GET', $this->normalizedUrl);

	        $this->fetchMetaData();
	        $this->fetchFoundUrls();
	        $this->fetchFoundImages();
	        $this->setResponse($client->getResponse());

	    } catch (ConnectException $e) {
	    	$this->setResponse(new Response($e->getMessage(), 410, []));
	    }

    	return $this;
	}
	/**
	 * Check if the provided URL already exists in either the found or existing URLs
	 * @param  string $url
	 * @return boolean
	 */
    protected function urlExists($url) 
    {
        return $this->foundUrls->has(md5($url)) || $this->existingUrls->has(md5($url));
    }
    /**
	 * Check if the provided Image URL already exists in either the found or existing Images
	 * @param  string $image	the url for the image
	 * @return boolean
	 */
    protected function imageExists($image) 
    {
        return $this->foundImages->has(md5($image)) || $this->existingImages->has(md5($image));
    }
    /**
     * Fetch the found URL from the scrapped URL
     * @return self
     */
    protected function fetchFoundUrls()
    {
    	collect($this->_crawler->filterXpath('//a'))
    		->map(function ($link) {
    			// fetch the href from the node and normalize it agains our domain
	            return $this->normalizeUrl($link->getAttribute('href'));
	        })
	        ->filter(function ($link) {
	        	// remove URLs that are not from the same domain or are in the excluded urls or already exists in found or existing urls
	            return $this->urlHasSameDomain($link) && $this->urlIsAllowed($link) && ! $this->urlExists($link);
	        })
	        ->each(function($link) {
	        	// if the URL doesn't exist in neither the found or existing URLs, we add it the the collection
	            $this->foundUrls->put(md5($link), $link);
	        });

	    return $this;
    }
    /**
     * Checks if the provided url is from the same domain as the crawled url
     * @param  string $url found url
     * @return boolean
     */
    private function urlHasSameDomain($url)
    {
    	return str_contains($url, $this->domain);
    }
    /**
     * Chekcs if the provided url is allowed to be crawled
     * @param  string $url found url
     * @return boolean
     */
    private function urlIsAllowed($url)
    {
    	return ! str_contains($url, $this->excluded);
    }
    /**
     * Checks if the provided image is allowed
     * @param  strong $image image url
     * @return boolean
     */
    private function imageIsAllowed($image)
    {
    	return in_array(pathinfo($image, PATHINFO_EXTENSION), $this->allowedImageExtensions);
    }
    /**
     * Fetch the found Images from the scrapped URL
     * @return self
     */
    public function fetchFoundImages()
    {
    	collect($this->_crawler->filterXpath('//img'))
    		->map(function ($image) {
    			// fetch the src from the node and normalize it against our domain for relative paths
	            return [
	            	'url' => $this->normalizeUrl($image->getAttribute('src')),
	            	'alt' => $image->getAttribute('alt'),
	            ];
	        })
	        ->filter(function ($image) {
	        	// remove the images with extensions that are not allowed
	            return $this->imageIsAllowed($image['url']) && ! $this->imageExists($image['url']);
	        })
	        ->each(function($image) {
	            $this->foundImages->put(md5($image['url']), $image);
	        });

	    return $this;
    }
    /**
     * Fetch URL meta data
     * @return self
     */
    private function fetchMetaData()
    {
    	collect($this->_crawler->filterXpath('//head/meta'))
    		->reject(function($meta) {
    			return empty($meta->getAttribute('name')) && empty($meta->getAttribute('property')) && empty($meta->getAttribute('itemprop')); 
    		})
    		->map(function($meta) {
    			return [
    				'name' =>  $meta->getAttribute('name') ?? 'no name',
    				'property' =>  $meta->getAttribute('property') ?? 'no property',
    				'itemprop' =>  $meta->getAttribute('itemprop') ?? 'no itemprop',
    				'content' => $meta->getAttribute('content'),
    				'html' => $meta->ownerDocument->saveHTML($meta),
    			];
	        })
	        ->each(function($meta) {
	        	$this->metaData->put($this->getMetaKey($meta), $meta);
	        });

	    $this->metaData->put('page:title', $this->_crawler->filterXpath('//head/title')->extract('_text')[0] ?? '');

	    return $this;
    }
    /**
     * Normalize URLs according to PSR-7 rules.
     * Relative paths will be converted to full urls based on the site domain
     * @param  string $url 	Raw url string
     * @return string      	Normalized url string
     */
    public function normalizeUrl($url)
    {
        $url = new Uri($url);
        $base_url = new Uri($this->site->canonical_url);

        // if( Uri::isAbsolutePathReference($url)) {
        //     $url = Uri::resolve($base_url, $url);
        // }
        if( empty ($url->getHost())) {
            $url = Uri::resolve($base_url, $url);
        }
        if( empty ($url->getScheme())) {
            $url = Uri::resolve($base_url, $url);
        }

        return (string) $url;
    }
    /**
     * Get the domain name from the URL
     * @param  string $url
     * @return string
     */
    public function getDomain($url) 
    {
        $domain = strtolower(trim($url));

        $domain = parse_url($domain, PHP_URL_HOST);

        $count = substr_count($domain, '.');

        if($count === 2) {
            if(strlen(explode('.', $domain)[1]) > 3) 
                $domain = explode('.', $domain, 2)[1];
        } 
        elseif ($count > 2) {
            echo $count;
            $domain = $this->getDomain(explode('.', $domain, 2)[1]);
        }

        return $domain;
    }
    /**
     * Helper function to assign a key to the meta data
     * 
     * @param  array $meta
     * @return string $meta_key
     */
    function getMetaKey($meta) {
    	$meta_key = str_random(10);

    	if (isset($meta['name']) && !empty($meta['name'])) {
    		$meta_key = 'name:' . $meta['name'];
    	}
    	elseif(isset($meta['property']) && !empty($meta['property'])) {
    		$meta_key = 'property:' . $meta['property'];	
    	}
    	elseif(isset($meta['itemprop']) && !empty($meta['itemprop'])) {
    		$meta_key = 'itemprop:' . $meta['itemprop'];	
    	}

    	return $meta_key;
    }
    /**
     * Getter for the found urls collection
     * @return Illuminate\Support\Collection
     */
    public function getFoundUrls()
    {
    	return $this->foundUrls;
    }
    /**
     * Getter for the found images collection
     * @return Illuminate\Support\Collection
     */
    public function getFoundImages()
    {
    	return $this->foundImages;
    }
    /**
     * Setter for the response
     * @return Guzzle\Response
     */
    public function setResponse($response)
    {
    	return $this->response = $response;
    }
    /**
     * Getter for the response
     * @return Guzzle\Response
     */
    public function getResponse()
    {
    	return $this->response;
    }
    /**
     * Getter for the meta data
     * @return Guzzle\Response
     */
    public function getMetaData()
    {
    	return $this->metaData;
    }
}