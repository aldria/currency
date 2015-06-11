<?php

namespace aldria\currency\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Statement;

class Extension extends CompilerExtension {

    private function getDefaultConfig() {
        return [
            'currency' => 'Kč',
            'decimals' => 2,
            'decimalMark' => ',',
            'thousandsSep' => ' ',
            'priceFormat' => '{price} {currency}',
            'filterName' => 'price',
        ];
    }

    public function loadConfiguration() {
        $config = $this->getConfig($this->getDefaultConfig());
        $builder = $this->getContainerBuilder();

        $builder->addDefinition($this->prefix('currencyHelper'))
                ->setClass('aldria\currency\CurrencyHelper', [
                    'currency' => $config['currency'],
                    'decimals' => $config['decimals'],
                    'decimalMark' => $config['decimalMark'],
                    'thousandsSep' => $config['thousandsSep'],
                    'priceFormat' => $config['priceFormat'],
        ]);

        if ($builder->hasDefinition('nette.latteFactory')) {
            $definition = $builder->getDefinition('nette.latteFactory');
            $definition->addSetup('addFilter', array($config['filterName'], array($this->prefix('@currencyHelper'), 'format')));
        }
    }

}
