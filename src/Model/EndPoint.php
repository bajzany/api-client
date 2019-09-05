<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient\Model;

use Bajzany\ApiClient\Header;
use Bajzany\ApiClient\Provider;
use Bajzany\ApiClient\Request;
use Bajzany\ApiClient\Response;

abstract class EndPoint implements IEndPoint
{

	const METHOD = Provider::METHOD_GET;

	/**
	 * @var Header
	 */
	private $header;

	/**
	 * @return string
	 */
	public function getHttpMethod(): string
	{
		return $this::METHOD;
	}

	/**
	 * @return Header
	 */
	public function getHeader(): Header
	{
		if (!$this->header) {
			$this->header = new Header();
		}
		return $this->header;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return Provider::METHOD_GET;
	}

	/**
	 * @param Provider $provider
	 * @param array $response
	 * @return mixed
	 * @internal
	 */
	protected function processRawResponse(Provider $provider, array $response)
	{
		return new Response($response);
	}

	/**
	 * @param Provider $provider
	 * @param Request $request
	 * @return mixed|void
	 */
	protected function processRequest(Provider $provider, Request $request)
	{
		return;
	}

	/**
	 * @param Provider $provider
	 * @return mixed|Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function execute(Provider $provider)
	{
		$data = $this->processRawRequest($provider);
		$request = $provider->createRequest($this, $data);
		$provider->onRequest($provider, $this, $request);

		$this->processRequest($provider, $request);
		$response = $provider->getParsedResponse($request);
		$provider->onResponse($provider, $this, $response);

		return $this->processRawResponse($provider, $response);
	}

}
