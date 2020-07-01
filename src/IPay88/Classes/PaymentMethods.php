<?php


namespace IPay88\Classes;


class PaymentMethods
{
    # All payment method below is for MYR currency ONLY.
    static $myrCurrencyOnlyList = [
        2 => ['Credit Card', 'MYR'],
        6 => ['Maybank2U', 'MYR'],
        8 => ['Alliance Online', 'MYR'],
        10 => ['AmOnline', 'MYR'],
        14 => ['RHB Online', 'MYR'],
        15 => ['Hong Leong Online', 'MYR'],
        20 => ['CIMB Click', 'MYR'],
        22 => ['Web Cash', 'MYR'],
        31 => ['Public Bank Online', 'MYR'],
        48 => ['PayPal', 'MYR'],
        55 => ['Credit Card Pre-Auth', 'MYR'],
        102 => ['Bank Rakyat Internet Banking', 'MYR'],
        103 => ['Affin Online', 'MYR'],
        122 => ['Pay4Me (Delay payment)', 'MYR'],
        124 => ['BSN Online', 'MYR'],
        134 => ['Bank Islam', 'MYR'],
        152 => ['UOB', 'MYR'],
        163 => ['Hong Leong PEx+ (QR Payment)', 'MYR'],
        166 => ['Bank Muamalat', 'MYR'],
        167 => ['OCBC', 'MYR'],
        168 => ['Standard Chartered Bank', 'MYR'],
        173 => ['CIMB Virtual Account (Delay payment)', 'MYR'],
        198 => ['HSBC Online Banking', 'MYR'],
        199 => ['Kuwait Finance House', 'MYR'],
        210 => ['Boost Wallet', 'MYR'],
        243 => ['VCash', 'MYR'],
    ];

    static $foreignCurrencyList = [
        25 => ['Credit Card','USD'],
        35 => ['Credit Card','GBP'],
        36 => ['Credit Card','THB'],
        37 => ['Credit Card','CAD'],
        38 => ['Credit Card','SGD'],
        39 => ['Credit Card','AUD'],
        40 => ['Credit Card','MYR'],
        41 => ['Credit Card','EUR'],
        42 => ['Credit Card','HKD'],
    ];
}


























