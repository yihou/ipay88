<?php

namespace IPay88\Security;

class Response
{
	private $merchantKey;
	public static $validReferrer = "payment.ipay88.com.my";

    public function __construct($merchantKey)
    {
        $this->merchantKey = $merchantKey;
    }

    /**
     * @param $response
     * @return bool
     * @throws Exceptions\InvalidReferrerException
     * @throws Exceptions\InvalidSignatureException
     */
    public function validate($response)
    {
        if($response->getReferrer() !== self::$validReferrer)
        {
        	throw new Exceptions\InvalidReferrerException;
        }

        $sig = Signature::generateSignature(
        	$this->merchantKey,
        	$response->getMerchantCode(),
        	$response->getPaymentId(),
        	$response->getRefNo(),
        	preg_replace('/[.,]/', '', $response->getAmount()), //clear ',' and '.'
        	$response->getCurrency(),
        	$response->getStatus()
        	);

        if($response->getSignature() !== $sig)
        {
        	throw new Exceptions\InvalidSignatureException;
        }

        return true;
    }
}
