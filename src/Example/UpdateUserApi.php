<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient\Example;

use Bajzany\ApiClient\Model\EndPoint;
use Bajzany\ApiClient\Provider;
use Bajzany\ApiClient\Response;

class UpdateUserApi extends EndPoint
{

	const METHOD = Provider::METHOD_POST;

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var array
	 */
	private $data;

	public function __construct(int $userId, array $data)
	{
		$this->userId = $userId;
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getUrl(): string
	{
		return "http://crm.d/test/user-update/{$this->userId}";
	}

	/**
	 * @param Provider $provider
	 * @return mixed
	 * @internal
	 */
	public function processRawRequest(Provider $provider): array
	{
		return $this->data;
	}

	/**
	 * @param Provider $provider
	 * @return Response|mixed
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function execute(Provider $provider)
	{
		return parent::execute($provider);
	}
}
