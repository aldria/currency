<?php

namespace aldria\currency;

use Nette;


/**
* @method CurrencyHelper setCurrency(string $currency)
* @method CurrencyHelper setDecimals(int $decimals)
* @method CurrencyHelper setDecimalPoint(int $decimalPoint)
* @method CurrencyHelper setThousandsSep(string $thousandsSep)
* @method CurrencyHelper setPriceFormat(int $priceFormat)
*/
class CurrencyHelper extends Nette\Object
{
	
	/** @var string */
	private $currency;

	/** @var int */
	private $decimals;

	/** @var string */
	private $decimalPoint;

	/** @var string */
	private $thousandsSep;

	/** @var string */
	private $priceFormat;


	function __construct($currency = '€', $decimals = 2,  $decimalPoint = ',', $thousandsSep = ' ', $priceFormat = '{price} {currency}')
	{
		$this->currency = $currency;
		$this->decimals = $decimals;
		$this->decimalPoint = $decimalPoint;
		$this->thousandsSep = $thousandsSep;
		$this->priceFormat = $priceFormat;
	}


	public function format($price)
	{
		$price = number_format($price, $this->decimals, $this->decimalPoint, $this->thousandsSep);
		$search = array('{price}', '{currency}', ' ');
		$replace = array($price, $this->currency, "\xc2\xa0");
		return str_replace($search, $replace, $this->priceFormat);
	}

	
}