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
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('provider'))
			->setInject(TRUE)
			->setFactory(Provider::class);
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
