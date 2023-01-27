
 <!-- 
 * This is an official documentation of integrating "shurjoPay" in laravel.
 *
 * By following steps of this documentation, any user can be able to integrate "shurjoPay" pacakge easily. 
 * In this documentation , a sample integration process is also available.
 *
 * @author Rayhan Khan Ridoy
 * @since 2022-12-01 
 -->
 

# HOWTO use PHP plugin in laravel projects

This document describes how to use and integrate the ``shurjopay-plugin-php`` package into laravel projects.

#### Add the shurjopay-plugin-php as your project dependency.
```shell
$ composer require shurjomukhi/shurjopay-plugin-php
```

##### 📝 _To use the latest version of this package from **github**, add the below line in ``require`` block._
```
"shurjomukhi/shurjopay-plugin-php":"dev-main"
``` 
Also remember to add the repository line in ``composer.json``.
```
"repositories": [
                   {
                     "type": "vcs",
                     "url": "https://github.com/shurjopay-plugins/sp-plugin-php.git"
                   }
                ]
```
#### Then run ``composer update`` to download and install the package into your project. 

#### Add configuration like below to correctly for ``shurjopay-plugin-php`` package in your **Laravel** project.
```php
SP_USERNAME=sp_sandbox
SP_PASSWORD=pyyk97hu&6u6
SP_PREFIX=NOK
SHURJOPAY_API=https://sandbox.shurjopayment.com
SP_CALLBACK=https://sandbox.shurjopayment.com/response
SP_LOG_LOCATION=storage/logs
# CURLOPT_SSL_VERIFYPEER=0 only for local and non-SSL environment 
CURLOPT_SSL_VERIFYPEER=1
```
Sample .env file for laravel project can be found in samples folder.

#### Create an empty file named ``ShurjopayProvider.php`` under ``app/Providers``. Then copy the following section.
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ShurjopayPlugin\Shurjopay;
use ShurjopayPlugin\ShurjopayConfig;

class ShurjopayProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(Shurjopay::class, function ($app) {
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

#### Register the new service provider in ``config/app.php`` like shown below.
```php
'providers' => [
......
App\Providers\ShurjopayProvider::class,
......
],
```

#### Now, inject ``Shurjopay`` as dependency in the controller.

```php
   /* Shurjopay injected in a constructor */
   public function __construct(Shurjopay $sp)
   {
       $this->sp_instance = $sp;
   }
```
The above injected Shurjopay instance is now ready to be used to initiate payment request to shurjoPay system.
```php
   public function send_payment_request_to_shurjopay()
   {
       ......
       $payment_request = new PaymentRequest();
       ......
       $this->sp_instance->makePayment($payment_request);
       ......
   }
```

## References
1. [Laravel sample project using PHP plugin](https://github.com/shurjopay-plugins/sp-plugin-usage-examples/tree/dev/laravel-app-php-plugin) to get your feet wet with shurjopay.
