<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient\Model;

use Bajzany\ApiClient\Header;
use Bajzany\ApiClient\Provider;

interface IEndPoint
{

	/**
	 * @return string
	 */
	public function getUrl(): string;

	/**
	 * @return string
	 */
	public function getHttpMethod(): string;

	/**
	 * @return Header
	 */
	public function getHeader(): Header;

	/**
	 * @param Provider $provider
	 * @return mixed
	 */
	public function execute(Provider $provider);

}
