<?php

 class PaymentRequest
{
        // Constructor function of class
        public function __construct($object) { {
            // print_r($object);
            // exit;
                $this->currency = $object['currency'];
                $this->amount = $object['amount'];
                $this->discount_amount = $object['discount_amount'];
                $this->disc_percent = $object['disc_percent'];
                $this->customer_name = $object['customer_name'];
                $this->customer_phone =$object['customer_phone'];
                $this->customer_email= $object['customer_email'];
                $this->customer_address= $object['customer_address'];
                $this->customer_city = $object['customer_city'];
                $this->customer_state = $object['customer_state'];
                $this->customer_postcode= $object['customer_postcode'];
                $this->customer_country= $object['customer_country'];
                $this->shipping_address=$object['shipping_address'];
                $this->shipping_city=$object['shipping_city'];
                $this->shipping_country=$object['shipping_country'];
                $this->received_person_name=$object['received_person_name'];
                $this->shipping_phone_number=$object['shipping_phone_number'];
                $this->value1=$object['value1'];
                $this->value2=$object['value2'];
                $this->value3=$object['value3'];
                $this->value4=$object['value4'];
            }
           
        }
        /** Payment currency; e.g. BDT, USD etc */
        
    public $currency;
    /** Payment amount to be debited from consumer */
    public $amount;
    /** shurjopay discount_amount */
    public $discount_amount;
    public $disc_percent;

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
