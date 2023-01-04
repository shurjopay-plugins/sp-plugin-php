<?php
namespace ShurjopayPlugin\ShurjopayConfig;

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
define('SP_CALLBACK', 'http://localhost/php-app-php-plugin/return.php', false);
/** Log location of shurjopay php plugin */
define('SP_LOG_LOCATION', 'shurjoPay-plugin-log/', false);
