<?php

namespace aldria\currency;

use Nette;

/**
 * @method CurrencyHelper setCurrency(string $currency)
 * @method CurrencyHelper setDecimals(int $decimals)
 * @method CurrencyHelper setDecimalMark(int $decimalMark)
 * @method CurrencyHelper setThousandsSep(string $thousandsSep)
 * @method CurrencyHelper setPriceFormat(int $priceFormat)
 */
class CurrencyHelper extends Nette\Object {

    /** @var string */
    private $currency;

    /** @var int */
    private $decimals;

    /** @var string */
    private $decimalMark;

    /** @var string */
    private $thousandsSep;

    /** @var string */
    private $priceFormat;

    function __construct($currency = 'Kč', $decimals = 2, $decimalMark = ',', $thousandsSep = ' ', $priceFormat = '{price} {currency}') {
        $this->currency = $currency;
        $this->decimals = $decimals;
        $this->decimalMark = $decimalMark;
        $this->thousandsSep = $thousandsSep;
        $this->priceFormat = $priceFormat;
    }

    public function format($price, $currency = NULL, $decimals = NULL, $decimaPoint = NULL, $thousandsSep = NULL, $priceFormat = NULL) {
        $price = number_format($price, $decimals?$decimals:$this->decimals, 
                $decimaPoint?$decimaPoint:$this->decimalMark, $thousandsSep?$thousandsSep:$this->thousandsSep);
        $search = array('{price}', '{currency}', ' ');
        $replace = array($price, $currency?$currency:$this->currency, "\xc2\xa0");
        return str_replace($search, $replace, $priceFormat?$priceFormat:$this->priceFormat);
    }
}
