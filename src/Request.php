<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient;

use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;

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
		parent::__construct($method, $uri, $header->getParameters(), $this->createJson($body), $version);
	}

	/**
	 * @param $content
	 * @return false|string
	 */
	private function createJson($content)
	{
		$serializer = SerializerBuilder::create()
			->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new IdenticalPropertyNamingStrategy()))
			->build();

		$jsonContent = $serializer->serialize($content, 'json');

		return $jsonContent;
	}

}
