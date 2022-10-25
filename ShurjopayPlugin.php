<?php

	require_once 'configaration.php';
/**
 * 
 * PHP Plug-in service to provide shurjoPay get way services.
 * 
 * @author Md Wali Mosnad Ayshik
 * @since 2022-10-15
 */
#TODO Add package namespacing

	class ShurjopayPlugin {

		private $shurjopay_api  = SHURJOPAY_API;
		private $return_url  = SP_CALLBACK;
		private $prefix      = PREFIX;  
		private $SP_USER = SP_USERNAME;
		private $SP_PASS = SP_PASSWORD; 

		public function __construct() 
	{
		$this->domainName = $this->shurjopay_api;
		$this->auth_token_url = $this->domainName."api/get_token";
		#auth_token_url
		$this->checkout= $this->domainName."api/secret-pay";
		$this->verification_url= $this->domainName."api/verification";
	}

	#validation will be added soon 

	// public function validate($data) 
	// {
	//   $data = trim($data);
	//   $data = stripslashes($data);
	//   $data = htmlspecialchars($data);
	//   if(is_numeric($data))
	//     return $data;
	// }

	public function ShurjoPayToken ()
	{
		#Authinticate
	  $postFields = array(
	      'username' => $this->SP_USER,
	      'password' => $this->SP_PASS,
	  );
	  if (empty($this->auth_token_url) || empty($postFields)) return null;
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, $this->auth_token_url);
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
	    
		$trxn_data =  $this->prepareTransactionPayload($payload);
	    // var_dump($createpaybody);exit;
		//print_r(json_decode($trxn_data)->token);exit;
		$header=array(
	        'Content-Type:application/json',
	        'Authorization: Bearer '.json_decode($trxn_data)->token   
	    );

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $this->checkout);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $trxn_data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	    $response = curl_exec($ch);
		//print_r($response);exit();
		if($response === false)
		{
			echo json_encode(curl_error($ch));
		}

	    $urlData = json_decode($response); 
	    curl_close($ch);   
		//print_r($urlData);exit();
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
		curl_setopt($ch, CURLOPT_URL,  $this->verification_url);
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



#TODO object return

public function prepareTransactionPayload($payload)
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
	            'order_id' => $this->prefix.uniqid(),
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

	   
	return $createpaybody;
}

}
