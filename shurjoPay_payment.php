<?php

  require_once 'ShurjopayPlugin.php';

  $amount = (float) $_POST['pamount'];
  $sp_instance = new ShurjopayPlugin();
  
  $payload = array(

      'currency' => 'BDT',
      'amount' => $amount,                
      // Order information
      'order_id' => $prefix.uniqid(),
      'discsount_amount' => 0,
      'disc_percent' => 0,
      // Customer information
      'client_ip' => $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']),                
      'customer_name' =>  'MD Wali Mosnad Ayshik',
      'customer_phone' => '01775503498' ,
      'email' => 'test@example.com',
      'customer_address' => 'Dhaka',                
      'customer_city' => 'Dhaka',
      'customer_state' => 'Dhaka',
      'customer_postcode' => '1207',
      'customer_country' => 'Bangladesh',
      'value1' => 'Clint_IP'.'-'.$_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']),
      'value2' => 'value2',
      'value3' => 'value3',
      'value4' => 'value4'
  );

  // var_dump($payload);exit;

  $sp_instance->makePayment($payload);


?>
