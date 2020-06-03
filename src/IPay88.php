<?php

namespace App\Classes;

use IPay88\Security\Signature;

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
     * @access public
     * @param $args
     * @return mixed
     */
    public function makeRequestForm($args)
    {
        $args['merchantCode'] = $this->merchantCode;
        $args['signature'] = Signature::generateTransactionSignature(
            $args['refNo'],
            (int) $args['amount'],
            $args['currency'],
            $this->merchantKey,
            $this->merchantCode
        );
        $args['responseUrl'] = $this->responseUrl;
        $args['backendUrl'] = $this->backendResponseUrl;

        return $args;
    }
}
