<?php

namespace IPay88\Security;

class Signature
{
	/**
     * Generate signature to be used for transaction.
     *
     * You may verify your signature with online tool provided by iPay88
     * https://payment.ipay88.com.ph/epayment/testing/TestSignature_response.asp
     *
     * @access public
     *
     * accept arbitrary amount of params
     * @example IPay88\Security\Signature::generateSignature($key,$code,$refNo,$amount,$currency,[, $status])
     */
    public static function generateSignature()
    {
        $stringToHash = implode('',func_get_args());
        return base64_encode(self::_hex2bin(sha1($stringToHash)));
    }


    /**
     * Generate signature to be used for transaction.
     *
     * You may verify your signature with online tool provided by iPay88
     * https://payment.ipay88.com.ph/epayment/testing/TestSignature_response.asp
     *
     * @access public
     * @param string $refNo Unique merchant transaction id
     * @param int $amount Payment amount
     * @param string $currency Payment currency
     * @param string $merchantKey
     * @param string $merchantCode
     * @return string
     */
    public static function generateTransactionSignature($refNo, $amount, $currency, $merchantKey, $merchantCode)
    {
        $stringToHash = $merchantKey.$merchantCode.$refNo.$amount.$currency;
        return base64_encode(self::_hex2bin(sha1($stringToHash)));
    }

    /**
     *
     * equivalent of php 5.4 hex2bin
     *
     * @access private
     * @param string $source The string to be converted
     * @return string
     */
    private static function _hex2bin($source)
    {
    	$bin = '';
    	for ($i=0; $i < strlen($source); $i=$i+2) {
    		$bin .= chr(hexdec(substr($source, $i, 2)));
    	}
    	return $bin;
    }
}
