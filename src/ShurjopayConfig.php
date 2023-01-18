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

    /** Merchant prefix used to generate order id */
    public $ssl_verifypeer;
}