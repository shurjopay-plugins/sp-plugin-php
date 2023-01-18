# ![shurjoPay](https://shurjopay.com.bd/dev/images/shurjoPay.png) PHP plugin package

![Made With](https://badgen.net/badge/Made%20with/PHP)
[![Test Status](https://github.com/rust-random/rand/workflows/Tests/badge.svg?event=push)]()
![NPM](https://img.shields.io/npm/l/sp-plugin)
![version](https://badgen.net/badge/version/0.1.0)

Official shurjoPay PHP plugin for merchants or service providers to connect with [**_shurjoPay_**](https://shurjopay.com.bd) Payment Gateway v2.1 developed and maintained by [_**ShurjoMukhi Limited**_](https://shurjomukhi.com.bd).

This plugin package can be used with any PHP application or framework (e.g. Laravel, Symfony, CodeIgniter etc).
Also it makes it easy for developers to integrate with shurjoPay v2.1 with just three API calls:

1. **authenticate**: Authenticate merchants and generate token
1. **makePayment**: Create and send payment request
1. **verifyPayment**: Verify payment status at shurjoPay


Also reduces many of the things that you had to do manually

- Handles http request and errors
- Log generation at your prefarable path
- Authentication during checkout and verification of payments

## Audience

This document is intended for the developers and technical personnel of merchants and service providers who want to integrate the shurjoPay online payment gateway using PHP.

# How to use this shurjoPay Plugin

To integrate the shurjoPay Payment Gateway in your PHP project do the following tasks sequentially.

#### Step 1: Install the plugin inside your project environment

```
coming soon
```
OR

#### Step 1: Download the plugin from [shurjoPay-Plugins-PHP](https://github.com/shurjopay-plugins/sp-plugin-php)<br><br>

#### Step 2: Setup configuration parameters for shurjopay plugin in correctly in your application.

<!-- e.g. SP_USERNAME, SP_PASSWORD, SP_PREFIX for the order id, SHURJOPAY_API, SP_CALLBACK and SP_LOG_LOCATION.<br /> -->
* Create a `.env` file inside your project's root directory. Here is a sample .env configuration, `.env` is provided with shurjoPay sandbox(test) credentials.<br />
* Provide your live credentials in <b>`.env`</b> before going live.
```PHP
# shurjopay merchant username
SP_USERNAME='sp_sandbox'
# shurjopay merchant password
SP_PASSWORD='pyyk97hu&6u6'
# Merchant prefix used to generate order id
SP_PREFIX='NOK'
# shurjopay payment gateway API endpoint
SHURJOPAY_API='https://sandbox.shurjopayment.com'
# URL to redirect after completion of a payment
SP_CALLBACK='https://sandbox.shurjopayment.com/response'
# Log location of shurjopay php plugin
SP_LOG_LOCATION='shurjoPay-plugin-log'
# CURLOPT_SSL_VERIFYPEER=0 for Http(local server) and CURLOPT_SSL_VERIFYPEER= 1 Https(live server)
CURLOPT_SSL_VERIFYPEER=1
```

#### Step 3: Use the namespace and require_once from package in your code as necessary and initiate payment method.

```PHP
use ShurjopayPlugin\ShurjopayEnvReader;
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\PaymentRequest;

require_once __DIR__ . '/src/ShurjopayEnvReader.php';
require_once __DIR__ . '/src/Shurjopay.php';
require_once __DIR__ . '/src/PaymentRequest.php';
```

```PHP
# Initialize your .env path directory.
$env = new ShurjopayEnvReader(__DIR__ . '/_env');
$conf = $env->getConfig();
# Shurjopay to connect and integrate with shurjoPay payment gateway API.
$sp_instance = new Shurjopay($conf);
$request = new PaymentRequest();
# All the data will come from user end.
$request->currency = 'BDT';
$request->amount = 100;
$request->discountAmount = '0';
$request->discPercent = '0';
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
# These are custom value for additional data.
$request->value1 = 'value1';
$request->value2 = 'value2';
$request->value3 = 'value3';
$request->value4 = 'value4';
# Initiate payment method.
$sp_instance->makePayment($request);
```

Checkout this [PHP project](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/main/php-app-php-plugin/php-app-php-plugin) to see this plugin in action.


 Payment verification can be done after each transaction with shurjopay order id.<br />
#### Step 1: Use the namespace and require_once from package in your code for payment verification.
```PHP
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\ShurjopayEnvReader;

require_once __DIR__ . '/src/Shurjopay.php';
require_once __DIR__ . '/src/ShurjopayEnvReader.php';
```
```PHP
# Initialize your .env path directory.
$env = new ShurjopayEnvReader(__DIR__ . '/_env');
$conf = $env->getConfig();
$sp_instance = new Shurjopay($conf);
# Call verifyPayment with shurjopay_order_id for payment verification.
$shurjopay_order_id = trim($_REQUEST['order_id']);
$response_data = json_decode(json_encode($sp_instance->verifyPayment($shurjopay_order_id)));
```

## References

1. [PHP sample project](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/main/php-app-php-plugin/php-app-php-plugin) showing usage of the PHP plugin.
2. [Laravel sample project using PHP plugin](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/dev/laravel_app_php_plugin) to get your feet wet with shurjopay.
3. [Sample applications and projects](https://github.com/shurjopay-plugins/sp-plugin-usage-examples) in many different languages and frameworks showing shurjopay integration.
4. [shurjoPay Postman site](https://documenter.getpostman.com/view/6335853/U16dS8ig) illustrating the request and response flow using the sandbox system.
5. [shurjopay Plugins](https://github.com/shurjopay-plugins) home page on github

## License

This code is under the [MIT open source License](http://www.opensource.org/licenses/mit-license.php).

#### Please [contact](https://shurjopay.com.bd/#contacts) with shurjoPay team for more detail.

Copyright ©️2022 [ShurjoMukhi Limited](https://shurjomukhi.com.bd).
