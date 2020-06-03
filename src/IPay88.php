<?php

namespace App\Classes;

class IPay88
{
    private $merchantKey;
    public $merchantCode;
    public $responseUrl = null;
    public $backendResponseUrl = null;

    /**
     * IPay88 constructor.
     * @param string $merchantKey Provided by iPay88 OPSG and share between iPay88 and merchant only
     * @param string $merchantCode Merchant Code provided by iPay88 and use to uniquely identify the Merchant.
     * @param string $responseUrl
     * @param string $backendResponseUrl
     */
    public function __construct($merchantKey, $merchantCode, $responseUrl, $backendResponseUrl)
    {
        $this->merchantKey = $merchantKey;
        $this->merchantCode= $merchantCode;
        $this->responseUrl = $responseUrl;
        $this->backendResponseUrl = $backendResponseUrl;
    }

    /**
     * Generate signature to be used for transaction.
     *
     * You may verify your signature with online tool provided by iPay88
     * http://www.mobile88.com/epayment/testing/TestSignature.asp
     *
     * @access public
     * @param string $refNo Unique merchant transaction id
     * @param int $amount Payment amount
     * @param string $currency Payment currency
     * @return string
     */
    public function generateSignature($refNo, $amount, $currency)
    {
        $stringToHash = $this->merchantKey.$this->merchantCode.$refNo.$amount.$currency;
        return base64_encode(self::_hex2bin(sha1($stringToHash)));
    }

    /**
     *
     * equivalent of php 5.4 hex2bin
     *
     * @access private
     * @param string $source The string to be converted
     * @return string|null
     */
    private function _hex2bin($source)
    {
        $bin = null;
        for ($i=0; $i < strlen($source); $i=$i+2) {
            $bin .= chr(hexdec(substr($source, $i, 2)));
        }
        return $bin;
    }

    /**
     * @access public
     * @param boolean $multiCurrency Set to true to get payments optinos for multi currency gateway
     * @return bool|string[][]
     */
    public static function getPaymentOptions($multiCurrency = false)
    {
        $myrOnly = [
            2 => ['Credit Card','MYR'],
            6 => ['Maybank2U','MYR'],
            8 => ['Alliance Online','MYR'],
            10=> ['AmOnline','MYR'],
            14=> ['RHB Online','MYR'],
            15=> ['Hong Leong Online','MYR'],
            16=> ['FPX','MYR'],
            20=> ['CIMB Click', 'MYR'],
            22=> ['Web Cash','MYR'],
            48=> ['PayPal','MYR'],
            100 => ['Celcom AirCash','MYR'],
            102 => ['Bank Rakyat Internet Banking','MYR'],
            103 => ['AffinOnline','MYR']
        ];

        $multiCurrencyList = [
            25=> ['Credit Card','USD'],
            35=> ['Credit Card','GBP'],
            36=> ['Credit Card','THB'],
            37=> ['Credit Card','CAD'],
            38=> ['Credit Card','SGD'],
            39=> ['Credit Card','AUD'],
            40=> ['Credit Card','MYR'],
            41=> ['Credit Card','EUR'],
            42=> ['Credit Card','HKD'],
        ];

        return $multiCurrency ? $multiCurrencyList : $myrOnly;
    }

    /**
     * @access public
     * @param $args
     * @return mixed
     */
    public function makeRequestForm($args)
    {
        $args['merchantCode'] = $this->merchantCode;
        $args['signature'] = $this->generateSignature(
            $args['refNo'],
            (int) $args['amount'],
            $args['currency']
        );
        $args['responseUrl'] = $this->responseUrl;
        $args['backendUrl'] = $this->backendResponseUrl;

        return $args;
    }
}
