<?php

/**
 * PHP plugin class PaymentRequest to store payload values.
 *
 * @author Md Wali Mosnad Ayshik
 * @since 2022-10-15
 */
class PaymentRequest
{
    /** Payment currency; e.g. BDT, USD etc */
    public $currency;
    /** Payment amount to be debited from consumer */
    public $amount;
    /** shurjopay discountAmount */
    public $discountAmount;
    /** shurjopay discPercent */
    public $discPercent;
    /** shurjopay customerName */
    public $customerName;
    /** shurjopay customerPhone */
    public $customerPhone;
    /** shurjopay customerEmail */
    public $customerEmail;
    /** shurjopay customerAddress */
    public $customerAddress;
    /** shurjopay customerCity */
    public $customerCity;
    /** shurjopay customerState */
    public $customerState;
    /** shurjopay customerPostcode */
    public $customerPostcode;
    /** shurjopay customerCountry */
    public $customerCountry;
    /* Shipping information. optional */
    public $shippingAddress;
    public $shippingCity;
    public $shippingCountry;
    public $receivedPersonName;
    public $shippingPhoneNumber;

    /** Optional values if needed*/
    public $value1;
    public $value2;
    public $value3;
    public $value4;
}