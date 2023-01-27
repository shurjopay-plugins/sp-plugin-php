# ![shurjoPay](https://shurjopay.com.bd/dev/images/shurjoPay.png) PHP plugin package

![Made With](https://badgen.net/badge/Made%20with/PHP)
[![Test Status](https://github.com/rust-random/rand/workflows/Tests/badge.svg?event=push)]()
![NPM](https://img.shields.io/npm/l/sp-plugin)
![version](https://badgen.net/badge/version/0.1.0)

Official shurjoPay PHP plugin for merchants or service providers to connect with [**_shurjoPay_**](https://shurjopay.com.bd) Payment Gateway v2.1 developed and maintained by [_**ShurjoMukhi Limited**_](https://shurjomukhi.com.bd).

This plugin package can be used with any PHP application or framework (e.g. Laravel, Lumen, CodeIgniter, Symfony, CakePHP, Yii etc). Use this plugin in your CMS (Wordpress, Magento, Joomla, OpenCart, Drupal etc) projects or checkour our dedicated plugins for the renowned CMS.
It makes it easy for developers to integrate with shurjoPay v2.1 with just three API calls:

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

#### Add the shurjopay-plugin-php as your project dependency.
```shell
$ composer require shurjomukhi/shurjopay-plugin-php
```

#### Setup parameters for shurjopay plugin correctly in your application in a config file as shown below.

```PHP
# shurjopay merchant username
SP_USERNAME='sp_sandbox'
# shurjopay merchant password
SP_PASSWORD='pyyk97hu&6u6'
# Merchant prefix used to generate order id
SP_PREFIX='NOK'
# shurjopay payment gateway API endpoint
SHURJOPAY_API='https://sandbox.shurjopayment.com'
# URL to redirect after completion of a payment. Sample: https://sandbox.shurjopayment.com/response
SP_CALLBACK='http://localhost/your-php-app/return.php'
# Log location of shurjopay php plugin
SP_LOG_LOCATION='/var/log/shurjopay'
# CURLOPT_SSL_VERIFYPEER=0 only for local and non-SSL environment 
CURLOPT_SSL_VERIFYPEER=1
```
#### Note: Remember to use live credentials in config file before going in production.

#### Now, create instance of ``Shurjopay`` with ``ShurjopayConfig``. To read the parameters from config or env file, you may use the ``ShurjopayEnvReader``.
Check out test class to view an example.

```PHP
$env = new ShurjopayEnvReader(__DIR__ . '/_env');
$sp_instance = new Shurjopay($env->getConfig());
```
#### After that, initiate a payment request to shurjoPay using our plugin in your application. Below is a basic example code snippet.

```PHP
$request = new PaymentRequest();
# All the data will come from user end.
$request->currency = 'BDT';
$request->amount = 100;
$request->discountAmount = 0;
$request->discPercent = 0;
$request->customerName = 'Abdul Mannan';
$request->customerPhone = '01712345678';
$request->customerEmail = 'test@gmail.com';
$request->customerAddress = 'Dhaka';
$request->customerCity = 'Dhaka';
$request->customerState = 'Dhaka';
$request->customerPostcode = '1209';
$request->customerCountry = 'Bangladesh';
$request->shippingAddress = 'Sirajganj';
$request->shippingCity = 'Dhaka';
$request->shippingCountry = 'Bangladesh';
$request->receivedPersonName = 'Jalil Mia';
$request->shippingPhoneNumber = '01712345678';
# Custom data can be sent using these value[1-4] fields which will be returned back to you in response. Any type of data can be passed on; e.g. string, integer, array etc.
$request->value1 = array("val1", "val2", "val3");
$request->value2 = 'value2';
$request->value3 = 'value3';
$request->value4 = 'value4';

$sp_instance->makePayment($request);
```
#### Payment verification can be done after each transaction with shurjopay order id.
```php
$sp_instance->verifyPayment($order_id);
```
Check our documentation on verify for more details.


## References

1. [PHP sample project](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/main/php-app-php-plugin/php-app-php-plugin) showing usage of the PHP plugin.
2. [Laravel sample project using PHP plugin](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/dev/laravel_app_php_plugin) to get your feet wet with shurjopay.
2. [OpenCart plugin](https://github.com/shurjopay-plugins/sp-plugin-opencart)
2. [OpenCart sample project](https://github.com/shurjopay-plugins/sp-plugin-usage-opencart)
3. [Sample applications and projects](https://github.com/shurjopay-plugins/sp-plugin-usage-examples) in many different languages and frameworks showing shurjopay integration.
4. [shurjoPay Postman site](https://documenter.getpostman.com/view/6335853/U16dS8ig) illustrating the request and response flow using the sandbox system.
5. [shurjopay Plugins](https://github.com/shurjopay-plugins) home page on github

## License

This code is under the [MIT open source License](http://www.opensource.org/licenses/mit-license.php).

#### Please [contact](https://shurjopay.com.bd/#contacts) with shurjoPay team for more detail.

Copyright ©️2023 [ShurjoMukhi Limited](https://shurjomukhi.com.bd).
