<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient;

use Bajzany\ApiClient\Model\EndPoint;
use GuzzleHttp\Exception\BadResponseException;
use function GuzzleHttp\Psr7\str;
use Nette\SmartObject;
use Psr\Http\Message\ResponseInterface;

/**
 * @method onRequest(Provider $provider, EndPoint $endPoint, Request $request)
 * @method onResponse(Provider $provider, EndPoint $endPoint, $response)
 */
class Provider
{

	use SmartObject;

	const METHOD_GET = 'GET';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';
	const METHOD_DELETE = 'DELETE';

	/**
	 * @var callable[]
	 */
	public $onRequest = [];

	/**
	 * @var callable[]
	 */
	public $onResponse = [];

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $client;

	/**
	 * @var array
	 */
	private $config;

	public function __construct(array $config)
	{
		$this->config = $config;
		$this->client = new \GuzzleHttp\Client();
	}

	/**
	 * @param EndPoint $endPoint
	 * @param array $data
	 * @return Request
	 */
	public function createRequest(EndPoint $endPoint, array $data): Request
	{
		return new Request($endPoint->getHttpMethod(), $endPoint->getUrl(), $endPoint->getHeader(), $data);
	}

	/**
	 * @param Request $request
	 * @return mixed|ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	protected function getResponse(Request $request)
	{
		return $this->client->send($request, $this->config);
	}

	/**
	 * @param Request $request
	 * @return array
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getParsedResponse(Request $request): array
	{
		try {
			$response = $this->getResponse($request);
//
//			var_dump($response);
//			exit;

		} catch (BadResponseException $e) {
			$response = $e->getResponse();
		}
		$parsed = $this->parseResponse($response);

		return $parsed;
	}

	/**
	 * @param ResponseInterface $response
	 * @return array
	 */
	protected function parseResponse(ResponseInterface $response)
	{
		$content = (string) $response->getBody();
		if (empty($content)) {
			$content = (string)$response->getBody()->getContents();
		}
		$type = $this->getContentType($response);
		if (strpos($type, 'urlencoded') !== false) {
			parse_str($content, $parsed);
			return $parsed;
		}

		try {
			return $this->parseJson($content);
		} catch (\UnexpectedValueException $e) {
			if (strpos($type, 'json') !== false) {
				throw $e;
			}

			throw new \UnexpectedValueException(
				'Server error was encountered that did not contain a JSON body',
				0,
				$e
			);
		}
	}

	/**
	 * Attempts to parse a JSON response.
	 *
	 * @param  string $content JSON content from response body
	 * @return array Parsed JSON data
	 * @throws \UnexpectedValueException if the content could not be parsed
	 */
	private function parseJson($content)
	{
		$content = json_decode($content, true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new \UnexpectedValueException(sprintf(
				"Failed to parse JSON response: %s",
				json_last_error_msg()
			));
		}

		return $content;
	}

	/**
	 * Returns the content type header of a response.
	 *
	 * @param  ResponseInterface $response
	 * @return string Semi-colon separated join of content-type headers.
	 */
	private function getContentType(ResponseInterface $response)
	{
		return join(';', (array) $response->getHeader('content-type'));
	}

	/**
	 * @return \GuzzleHttp\Client
	 */
	public function getClient(): \GuzzleHttp\Client
	{
		return $this->client;
	}

}
