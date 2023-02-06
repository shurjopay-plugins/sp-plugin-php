<?php

namespace ShurjopayPlugin;

use ShurjopayPlugin\ShurjopayValidation;
use ShurjopayPlugin\ShurjopayConfig;

require_once __DIR__ . '/ShurjopayException.php';
require_once __DIR__ . '/ShurjopayConfig.php';
require_once __DIR__ . '/ShurjopayValidation.php';

/**
 * PHP plugin class to connect and integrate with shurjoPay payment gateway API.
 * There are three mandatory public functions which will need to access shurjoPay.<br>
 * 1. authenticate()-> makes client authenticate
 * 2. makePayment()-> generates payment url for checkout
 * 3. verifyPayment()-> makes payment verification
 * prepareCurlRequest, prepareTransactionPayload & logInfo() are internally.
 *
 * @author Md Wali Mosnad Ayshik
 * @author Rayhan khan Ridoy
 * @since 2022-10-15
 */
class Shurjopay
{
    private $conf;
    private $sp_token;
    private $sp_store;
	private $url_auth, $url_checkout, $url_verify;
    /** shurjopay payment gateway API endpoint */
    public function __construct(ShurjopayConfig $config)
    {
        $this->conf = $config;
        $this->url_checkout = $this->conf->api_endpoint . "/api/secret-pay";
        $this->url_auth = $this->conf->api_endpoint . "/api/get_token";
        $this->url_verify = $this->conf->api_endpoint . "/api/verification";
    }

    public function authenticate()
    {
        if (empty($this->conf->username) || empty($this->conf->password)) {
            $this->sp_log("Authentication process can not continue as username or password is empty");
            exit("Authentication process can not continue as username or password is empty");
        }

        $postFields = array('username' => $this->conf->username, 'password' => $this->conf->password);

        $response = $this->getHttpResponse($this->url_auth, 'POST', $postFields, array(''));
        if (!$response) {
            $this->sp_log("Authentication failed");
            return null;
        }
        $response = json_decode(json_encode($response), true);
        $this->sp_log("Token generated Successfully");
        $this->sp_token = $response['token'];
        $this->sp_store = $response['store_id'];
        return $this->sp_token;
    }

    /** @throws ShurjopayException */
    public function makePayment(PaymentRequest $payload)
    {
        $validation = new ShurjopayValidation();
        if (!$validation->checkInternetConnection()) {
            exit("Your have no internet connection! Please check your internet connection.");
        }
        $this->check_token("Payment process can not continue as no authentication token is available");

        $trxn_data = $this->prepareTransactionPayload($payload);
        if (!$validation->Validation($trxn_data))
            throw new ShurjopayException("Payment data validation failed", 0, null);

        $header = array(
            'Content-Type:application/json',
            'Authorization: Bearer ' . json_decode($trxn_data)->token
        );

        try {
            $response = $this->getHttpResponse($this->url_checkout, 'POST', $trxn_data, $header);
            if (!empty($response->checkout_url)) {
                $this->sp_log("Payment URL has been generated by shurjoPay!");
                header('Location: ' . $response->checkout_url);
                exit;
            } else {
                return $response; //object
            }
        } catch (ShurjopayException | \BadMethodCallException | \ArgumentCountError | \InvalidArgumentException $e) {
            $this->sp_log("Exception in Shurjopay->makePayment" . ". \n" . $e->getMessage());
            throw new ShurjopayException("Please check and resolve errors to make successful payment", 0, $e);
        }
    }

    private function check_token($msg)
    {
        if (!$this->sp_token) {
            $this->sp_token = $this->authenticate();
            if (!$this->sp_token) {
                $this->sp_log($msg);
                exit($msg);
            }
        }
        return true;
    }

    public function verifyPayment($shurjopay_order_id)
    {

        $this->check_token("Verification process can not continue as no authentication token is available");
        $header = array(
            'Content-Type:application/json',
            'Authorization: Bearer ' . $this->sp_token
        );
        $postFields = json_encode(array('order_id' => $shurjopay_order_id));
        try {
            $response = $this->getHttpResponse($this->url_verify, 'POST', $postFields, $header);
            $this->sp_log("Payment verification for " . $shurjopay_order_id . " was done successfully");
            return $response;
        } # Catching ShurjopayException custom exception and throwing it to ShurjopayException
        catch (ShurjopayException | \BadMethodCallException | \ArgumentCountError | \InvalidArgumentException $e) {
            $this->sp_log("Exception in Shurjopay->verifyPayment" . ". \n" . $e->getMessage());
            throw new ShurjopayException("Please check and resolve errors to make successful payment", 0, $e);
        }
    }

    public function prepareTransactionPayload($payload)
    {

        return json_encode(
            array(
                # store information
                'token' => $this->sp_token,
                'store_id' => $this->sp_store,
                'prefix' => $this->conf->order_prefix,
                'currency' => $payload->currency,
                'return_url' => $this->conf->callback_url,
                'cancel_url' => $this->conf->callback_url,
                'amount' => $payload->amount,
                # Order information
                'order_id' => $this->conf->order_prefix . uniqid(),
                'discount_amount' => $payload->discountAmount,
                'disc_percent' => $payload->discPercent,
                # Customer information
                'client_ip' => $this->getClientIpOrHost(),
                'customer_name' => $payload->customerName,
                'customer_phone' => $payload->customerPhone,
                'customer_email' => $payload->customerEmail,
                'customer_address' => $payload->customerAddress,
                'customer_city' => $payload->customerCity,
                'customer_state' => $payload->customerState,
                'customer_postcode' => $payload->customerPostcode,
                'customer_country' => $payload->customerCountry,
                'shipping_address' => $payload->shippingAddress,
                'shipping_city' => $payload->shippingCity,
                'shipping_country' => $payload->shippingCountry,
                'received_person_name' => $payload->receivedPersonName,
                'shipping_phone_number' => $payload->shippingPhoneNumber,
                'value1' => $payload->value1,
                'value2' => $payload->value2,
                'value3' => $payload->value3,
                'value4' => $payload->value4
            )
        );
    }

    public function getClientIpOrHost()
    {
        if (isset($_SERVER['REMOTE_ADDR']))
            return $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
        return gethostname();
    }

    /**
     * Prepare and send HTTP requests using curl library and process response.
     *
     * @param $url Destination URL
     * @param $method POST or GET
     * @param $payload_data
     * @param $header Header options
     * @return mixed
     */
    public function getHttpResponse($url, $method, $payload_data, $header)
    {
        try {
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $url,
                    CURLOPT_HTTPHEADER => $header,
                    CURLOPT_POST => 1,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POSTFIELDS => $payload_data,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => $this->conf->ssl_verifypeer,
                )
            );
            $response = curl_exec($curl);
            return (json_decode($response));
        } # Catching ShurjopayException custom exception and throwing it to ShurjopayException
        catch (ShurjopayException | \BadMethodCallException | \ArgumentCountError | \InvalidArgumentException $e) {
            $this->sp_log("Exception in Shurjopay->verifyPayment" . ". \n" . $e->getMessage());
            throw new ShurjopayException("Please check and resolve errors to make successful payment", 0, $e);
        } finally {
            curl_close($curl);
        }
        return null;
    }

     
    /**
     * This function is used to create log and make directory if not exist.
     * @param  mixed $log_msg
     * @return void
     */
    public function sp_log($log_msg)
    {

        try {
            #file_put_contents takes care of opening the file, writing the contents, and closing the file.
            $log_file_data = $this->conf->log_path . '/shurjopay-plugin.log';
            $log_msg = gmdate('Y-m-d H:i:s') . " ShurjopayPlugin: " . $log_msg;

            if (!file_exists($this->conf->log_path)) {
                mkdir($this->conf->log_path, 0755, true);
            }

            file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
        } # Catching ShurjopayException custom exception and throwing it to ShurjopayException
        catch (ShurjopayException | \BadMethodCallException | \ArgumentCountError | \InvalidArgumentException $e) {
            $this->sp_log("Exception in Shurjopay->sp_log" . ". \n" . $e->getMessage());
            throw new ShurjopayException("Please check and resolve errors to make successful shurjoPay log", 0, $e);
        }
    }
}