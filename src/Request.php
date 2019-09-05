<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient;

class Request extends \GuzzleHttp\Psr7\Request
{

	/**
	 * @param string $method
	 * @param $uri
	 * @param Header $header
	 * @param array $body
	 * @param string $version
	 */
	public function __construct(string $method, $uri, Header $header, array $body, string $version = '1.1')
	{
		parent::__construct($method, $uri, $header->getParameters(), json_encode($body), $version);
	}

}
