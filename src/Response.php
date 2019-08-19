<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace ApiClient;

class Response
{

	/**
	 * @var int
	 */
	private $code;

	/**
	 * @var \stdClass
	 */
	private $data;

	/**
	 * @var array
	 */
	private $errors = [];

	/**
	 * @var array
	 */
	private $messages = [];

	public function __construct(array $response)
	{
		$this->buildResponse($response);
	}

	private function buildResponse(array $response)
	{
		if (isset($response['code'])) {
			$this->code = $response['code'];
		}
		$this->data = new \stdClass();
		if (isset($response['data'])) {
			$this->data = (object)$response['data'];
		}
		if (isset($response['errors'])) {
			$this->errors = $response['errors'];
		}
		if (isset($response['messages'])) {
			$this->messages = $response['messages'];
		}
	}

	/**
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->code === 200;
	}

	/**
	 * @return int
	 */
	public function getCode(): int
	{
		return $this->code;
	}

	/**
	 * @return \stdClass
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

	/**
	 * @return array
	 */
	public function getMessages(): array
	{
		return $this->messages;
	}

}
