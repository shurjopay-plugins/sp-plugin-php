
 <!-- 
 * This is an official documentation of integrating "shurjoPay" in laravel.
 *
 * By following steps of this documentation, any user can be able to integrate "shurjoPay" pacakge easily. 
 * In this documentation , a sample integration process is also available.
 *
 * @author Rayhan Khan Ridoy
 * @since 2022-12-01 
 -->
 

# ![image](https://user-images.githubusercontent.com/57352037/170198396-932692aa-3354-4cf0-abc1-2b8ef43a6de3.png) Include ``shurjopay-plugin-php`` into laravel application
[![Test Status](https://github.com/rust-random/rand/workflows/Tests/badge.svg?event=push)]()
[![Stable](https://img.shields.io/badge/Stable-v0.1.0-green)]()
[![License](https://img.shields.io/badge/License-MIT-blue)]()
[![Rating](https://img.shields.io/badge/Rating-*****-green)]()
[![Depandency](https://img.shields.io/badge/Depandency-No-blue)]()

Official documentation for shurjoPay plugin developers to connect with [**_shurjoPay_**](https://shurjopay.com.bd) Payment Gateway ``` v2.1.0 ``` developed and maintained by [_**ShurjoMukhi Limited**_](https://shurjomukhi.com.bd). This documentation can be used to integrate ``shurjopay-plugin-php`` into laravel application.

## Audience

This document is intended for the developers and technical personnel who want to integrate the shurjoPay online payment gateway by ``shurjopay-plugin-php`` in laravel application.

# How to use shurjopay-plugin-php package in laravel ?
To integrate the shurjoPay Payment Gateway using ``shurjopay-plugin-php``, kindly do the following tasks sequentially.

#### Step-1: Install the package inside your project environment.

```
"shurjomukhi/shurjopay-plugin-php":"^0.1.0"
```

Or, Open your project's ``composer.json`` file . Then , copy below line and put it into the body of ``require`` block.

```
"shurjomukhi/shurjopay-plugin-php":"dev-main"
``` 
Next , copy below block of codes and put into "composer.json" 
```
"repositories": [
                   {
                     "type": "vcs",
                     "url": "https://github.com/shurjopay-plugins/sp-plugin-php.git"
                   }
                ]
```
By running below command , our ``shurjoPay`` package will be loaded into your project. 
```
composer update
```
#### Step-2: Add configuration in ``.env`` .
```
SP_USERNAME=sp_sandbox
SP_PASSWORD=pyyk97hu&6u6
SP_PREFIX=NOK
SHURJOPAY_API=https://sandbox.shurjopayment.com
SP_CALLBACK=https://sandbox.shurjopayment.com/response
SP_LOG_LOCATION=shurjoPay-plugin-log
# CURLOPT_SSL_VERIFYPEER=0 only for local and non-SSL environment 
CURLOPT_SSL_VERIFYPEER=1
``` 
#### Step-3: Kindly , Make a Service-Provider as ``ShurjopayProvider.php`` and  also customize it.

```
php artisan make:provider ShurjopayProvider
```
Inside ``app/Providers/ShurjopayProvider.php`` file , remove every lines and paste below lines there.
```
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\ShurjopayConfig;

class ShurjopayProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(Shurjopay::class, function ($app) {
            return new Shurjopay($this->getShurjopayConfig());
        });
    }

    private function getShurjopayConfig(): ShurjopayConfig
    {
        $conf = new ShurjopayConfig();
        $conf->username = env('SP_USERNAME');
        $conf->password = env('SP_PASSWORD');
        $conf->api_endpoint = env('SHURJOPAY_API');
        $conf->callback_url = env('SP_CALLBACK');
        $conf->log_path = env('SP_LOG_LOCATION');
        $conf->order_prefix = env('SP_PREFIX');
        $conf->ssl_verifypeer = env('CURLOPT_SSL_VERIFYPEER');
        return $conf;
    }

}
```
Then , open ``config/app.php`` file and put below line into ``providers`` array for registering ``ShurjopayProvider``.

```
App\Providers\ShurjopayProvider::class,
```
#### Step-4: Integrating controller setup :-
Use below namespaces in your controller .

```
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\PaymentRequest;
```
Please make a constructor & inject ``Shurjopay`` class as perameter into your controller class and follow below procedures .

```
   /* Defining a public variable */
   public $sp;

   /* "Shurjopay" injected in a constructor */
   public function __construct(Shurjopay $sp)
   {
       $this->sp = $sp;
   }

   /* Payment making method */
   public function make_payment_request()
   {

       /* Creating instance of PaymentRequest class */
       $request = new PaymentRequest();

       /* Initializing all feilds */

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
       $request->value1 = 'value1';
       $request->value2 = 'value2';
       $request->value3 = 'value3';
       $request->value4 = 'value4';

       /* Calling makePayment() method from plugin */
       return $this->sp->makePayment($request);
   }
```
#### Payment verification can be done after each transaction with shurjopay_order_id :-

```
 /* Payment verifying method */
 public function verifyPayment($shurjopay_order_id)
    {
        /* Calling the "verifyPayment()" method from plugin */
        return $this->sp->verifyPayment($sp_order_id);
    }
```
#### Step-5: Ready to run.
Now application is ready to work. Just give another command in terminal

```
php artisan serve
```
Check our documentation on verify for more details.

## References

1. [PHP sample project](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/main/php-app-php-plugin/php-app-php-plugin) showing usage of the PHP plugin.
2. [Laravel sample project using PHP plugin](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/dev/laravel-app-php-plugin) to get your feet wet with shurjopay.
2. [OpenCart plugin](https://github.com/shurjopay-plugins/sp-plugin-opencart)
2. [OpenCart sample project](https://github.com/shurjopay-plugins/sp-plugin-usage-opencart)
3. [Sample applications and projects](https://github.com/shurjopay-plugins/sp-plugin-usage-examples) in many different languages and frameworks showing shurjopay integration.
4. [shurjoPay Postman site](https://documenter.getpostman.com/view/6335853/U16dS8ig) illustrating the request and response flow using the sandbox system.
5. [shurjopay Plugins](https://github.com/shurjopay-plugins) home page on github

## License

This code is under the [MIT open source License](http://www.opensource.org/licenses/mit-license.php).

#### Please [contact](https://shurjopay.com.bd/#contacts) with shurjoPay team for more detail.

Copyright ©️2023 [ShurjoMukhi Limited](https://shurjomukhi.com.bd).
