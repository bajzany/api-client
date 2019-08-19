<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace ApiClient;

class Header
{

	/**
	 * @var array
	 */
	private $parameters = [];

	public function addParameter($name, $value)
	{
		$this->parameters[$name] = $value;
	}

	/**
	 * @return array
	 */
	public function getParameters(): array
	{
		return $this->parameters;
	}

}
