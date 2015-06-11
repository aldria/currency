<?php

namespace aldria\currency\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Statement;


class Extension extends CompilerExtension
{
	private function getDefaultConfig()
	{
		return [
			'price' => [
				'currency' => 'Kč',
				'decimals' => 2,
				'decimalPoint' => ',',
				'thousandsSep' => ' ',
				'priceFormat' => '{price} {currency}',
				'filterName' => 'price',
			],
		];
	}


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->getDefaultConfig());
		$builder = $this->getContainerBuilder();

		$priceConfig = $config['price'];
		$builder->addDefinition($this->prefix('currencyHelper'))
			->setClass('aldria\currency\currencyHelper', [
				'currency' => $priceConfig['currency'],
				'decimals' => $priceConfig['decimals'],
				'decimalPoint' => $priceConfig['decimalPoint'],
				'thousandsSep' => $priceConfig['thousandsSep'],
				'priceFormat' => $priceConfig['priceFormat'],
			]);

		if ($builder->hasDefinition('nette.latteFactory')) {
			$definition = $builder->getDefinition('nette.latteFactory');
			$definition->addSetup('addFilter', array($config['price']['filterName'], array($this->prefix('@currencyHelper'), 'format')));
		}
	}

}
