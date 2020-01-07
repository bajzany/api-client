<?php

/**
 * Author: Radek Zíka
 * Email: radek.zika@dipcom.cz
 */

namespace Bajzany\ApiClient\DI;

use Bajzany\ApiClient\Provider;
use Nette\Configurator;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;

class ApiClientExtension extends CompilerExtension
{

	private $defaults = [
		'verify' => FALSE,
		'connect_timeout' => 3.14
	];

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);
		$builder->addDefinition($this->prefix('bajzanyProvider'))
			->setInject(TRUE)
			->setFactory(Provider::class, [$config]);
	}

	/**
	 * @param Configurator $configurator
	 */
	public static function register(Configurator $configurator)
	{
		$configurator->onCompile[] = function ($config, Compiler $compiler) {
			$compiler->addExtension('ApiClientExtension', new ApiClientExtension());
		};
	}
}
