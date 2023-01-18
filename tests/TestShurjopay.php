<?php

namespace ShurjopayPlugin;

use ShurjopayPlugin\ShurjopayEnvReader;
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\PaymentRequest;

require_once __DIR__ . '/../src/ShurjopayEnvReader.php';
require_once __DIR__ . '/../src/Shurjopay.php';
require_once __DIR__ . '/../src/PaymentRequest.php';

$env = new ShurjopayEnvReader(__DIR__ . '/_env');
$conf = $env->getConfig();
print_r($conf);
$sp_obj = new Shurjopay($conf);

$pay_res = $sp_obj->makePayment(paymentRequest());
var_dump($pay_res);

// Check / verify the payment 
print_r($sp_obj->verifyPayment($pay_res['sp_order_id']));

function paymentRequest()
{
    $request = new PaymentRequest();

    $request->currency = 'BDT';
    $request->amount = 10.00;
    $request->discountAmount = 0;
    $request->discPercent = 0;
    $request->customerName = 'MD Wali Mosnad Ayshik';
    $request->customerPhone = '01775503498';
    $request->customerEmail = 'test@gmail.com';
    $request->customerAddress = 'Dhaka';
    $request->customerCity = 'Dhaka';
    $request->customerState = 'Dhaka';
    $request->customerPostcode = '1207';
    $request->customerCountry = 'Bangladesh';
    $request->shippingAddress = 'Sirajganj';
    $request->shippingCity = 'Dhaka';
    $request->shippingCountry = 'Bangladesh';
    $request->receivedPersonName = 'Ayshik';
    $request->shippingPhoneNumber = '01775503498';
    $request->value1 = 'value1';
    $request->value2 = 'value2';
    $request->value3 = 'value3';
    $request->value4 = 'value4';
    return $request;
}
