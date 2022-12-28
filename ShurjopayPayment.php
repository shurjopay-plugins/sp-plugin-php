<?php

class ShurjopayPayment
{

    /** Payment currency; e.g. BDT, USD etc */
    public $currency;
    /** Payment amount to be debited from consumer */
    public $paymentAmount;
    /** shurjopay discount_amount */
    public $discountAmount;
    public $discountPercent;

    public $customer_name;
    public $customer_phone;
    public $customer_email;
    public $customer_address;
    public $customer_city;
    public $customer_state;
    public $customer_postcode;
    public $customer_country;

    /* Shipping information. optional ??? TODO */
    public $shipping_address;
    public $shipping_city;
    public $shipping_country;
    public $received_person_name;
    public $shipping_phone_number;

    /** Optional values if needed*/
    public $value1;
    public $value2;
    public $value3;
    public $value4;

}
