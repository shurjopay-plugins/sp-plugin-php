<?php

	require_once 'configaration.php';
/**
 * 
 * PHP Plug-in service to provide shurjoPay get way services.
 * 
 * @author Md Wali Mosnad Ayshik
 * @since 2022-10-15
 */

	class ShurjopayPlugin {

		private $connection_url  = CONNECTION_URL;
		private $return_url  = RETURN_URL;
		public $prefix      = PREFIX;  
		private $SP_USER = SP_USERNAME;
		private $SP_PASS = SP_PASSWORD; 

		public function __construct() 
	{
		$this->domainName = $this->connection_url;
		$this->get_token = $this->domainName."api/get_token";
		$this->checkout = $this->domainName."api/secret-pay";
		$this->verification = $this->domainName."api/verification/";
	}
	public function validate($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  if(is_numeric($data))
	    return $data;
	}

	public function ShurjoPayToken ()
	{
	  $postFields = array(
	      'username' => $this->SP_USER,
	      'password' => $this->SP_PASS,
	  );
	  if (empty($this->get_token) || empty($postFields)) return null;
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, $this->get_token);
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	  $response = curl_exec($ch);
	  if($response === false)
	  {
	    echo json_encode(curl_error($ch));
	  }
	  curl_close($ch);
	  return $response;

	}

	public function makePayment($payload)
	{
	    $token   = json_decode($this->ShurjoPayToken(), true);
	    $createpaybody= json_encode ( 
	        array(
	            // store information
	            'token' => $token['token'],
	            'store_id' =>$token['store_id'],
	            'prefix' => $this->prefix,                              
	            'currency' => $payload['currency'],
	            'return_url' => $this->return_url,
	            'cancel_url' =>  $this->return_url,
	            'amount' => $payload['amount'],                
	            // Order information
	            'order_id' => $payload['order_id'],
	            'discsount_amount' => $payload['discsount_amount'],
	            'disc_percent' => $payload['disc_percent'],
	            // Customer information
	            'client_ip' => $payload['client_ip'],                
	            'customer_name' => $payload['customer_name'],
	            'customer_phone' => $payload['customer_phone'],
	            'customer_email' => $payload['email'],
	            'customer_address' => $payload['customer_address'],                
	            'customer_city' => $payload['customer_city'],
	            'customer_state' => $payload['customer_state'],
	            'customer_postcode' => $payload['customer_postcode'],
	            'customer_country' => $payload['customer_country'],
	            'value1' => $payload['value1'],
	            'value2' => $payload['value2'],
	            'value3' => $payload['value3'],
	            'value4' => $payload['value4']
	        )
	    );

	    $header=array(
	        'Content-Type:application/json',
	        'Authorization: Bearer '.$token['token']    
	    );

	    // var_dump($createpaybody);exit;

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $this->checkout);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $createpaybody);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    $response = curl_exec($ch);
		if($response === false)
		{
			echo json_encode(curl_error($ch));
		}

	    $urlData = json_decode($response); 
	    curl_close($ch);   
	    header('Location: '.$urlData->checkout_url);
	}



	public function verifyOrder($shurjopay_order_id)
	{
		// echo $order_id;exit;

		$token   = json_decode($this->ShurjoPayToken(), true);
		$header=array(
		    'Content-Type:application/json',
		    'Authorization: Bearer '.$token['token']    
		);
		$postFields = json_encode (
		        array(
		            'order_id' => $shurjopay_order_id
		        )
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,  $this->verification);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/0 (Windows; U; Windows NT 0; zh-CN; rv:3)");
		$response = curl_exec($ch); 
		if($response === false)
		{
		    echo json_encode(curl_error($ch));
		}
		curl_close($ch);   
		return $response;
	}

}
