<?php

namespace ShurjopayPlugin;

class ShurjopayConfig
{
    /** merchant store username assigned by shurjopay system */
    public $username;

    /** merchant store password assigned by shurjopay system */
    public $password;

    /** shurjopay payment gateway API endpoint; e.g. https://sandbox.shurjopayment.com */
    public $api_endpoint;

    /** URL to redirect after completion of a payment. e.g. https://sandbox.shurjopayment.com/response */
    public $callback_url;

    /** Log path or directory to store PHP plugin logs */
    public $log_path;

    /** Merchant prefix used to generate order id */
    public $order_prefix;
}

// TODO remove all constant variables
// Configuration constants for shurjopay plugin
/** shurjopay merchant username */
define('SP_USERNAME', 'sp_sandbox', false);
/** shurjopay merchant password */
define('SP_PASSWORD', 'pyyk97hu&6u6', false);
/** Merchant prefix used to generate order id */
define('SP_PREFIX', 'NOK', false);
/** shurjopay payment gateway API endpoint */
define('SHURJOPAY_API', 'https://sandbox.shurjopayment.com/', false);
/** URL to redirect after completion of a payment */
define('SP_CALLBACK', 'https://sandbox.shurjopayment.com/response', false);
/** Log location of shurjopay php plugin */
define('SP_LOG_LOCATION', 'shurjoPay-plugin-log/', false);
