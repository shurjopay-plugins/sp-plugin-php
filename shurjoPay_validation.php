<?php
/**
 *
 * PHP Plug-in service to provide shurjoPay get way services.
 *
 * @author Md Wali Mosnad Ayshik
 * @since 2022-10-15
 */
/**
 * Prepare a method for checking internet connection from client-side
 *
 * @return bool $is_conn
 */

function checkInternetConnection()
{
  $connected = @fsockopen('www.google.com', 80);

  if ($connected) {
    $is_conn = true; //action when connected
    fclose($connected);
  } else {
    $is_conn = false; //action in connection failure
  }
  return $is_conn;
}
  /**
     * Validate  payload required data
     *
     * @param  mixed $payload_data
     * This is a validation method whitch has all of payload data and it sends data for null & formate validation.
     */
function Validation($payload_data)
{
  $payload_data = (json_decode($payload_data));
  if ($payload_data->amount == '0') {
    print_r("shurjoPay don't accept 0 amount");
    exit;
  }

  if (
    emptyCheck(
      'Currency',
      $payload_data->currency
    ) && emptyCheck(
      'Return Url',
      $payload_data->return_url
    ) && emptyCheck(
      'Amount',
      $payload_data->amount
    ) && emptyCheck(
      'Discount Amount',
      $payload_data->discsount_amount
    ) && emptyCheck(
      'Discount percentange',
      $payload_data->disc_percent
    ) && emptyCheck(
      'Customer Name',
      $payload_data->customer_name
    ) && emptyCheck(
      'Customer Phone',
      $payload_data->customer_phone
    ) && emptyCheck(
      'Customer Email',
      $payload_data->customer_email
    ) && emptyCheck(
      'Customer Address',
      $payload_data->customer_address
    ) && emptyCheck(
      'Customer City',
      $payload_data->customer_city
    ) && emptyCheck(
      'Customer State',
      $payload_data->customer_state
    ) && emptyCheck(
      'Customer Postcode',
      $payload_data->customer_postcode
    ) && emptyCheck(
      'Customer Country',
      $payload_data->customer_country
    ) && emailCheck($payload_data->customer_email) && phoneCheck($payload_data->customer_phone)
  ) {
    return true;
  } else {
    return false;
  }

}


/**
 * emptyCheck
 *This method is for checking empty data and null data.
 * @param  mixed $type
 * @param  mixed $data
 * @return void
 */
function emptyCheck($type, $data)
{
  if ($data == "" || $data == null) {
    Print_r("$type is empty or null please check");
  } else {
    return true;

  }
}

/**
 * emailCheck
 *This method is for checking email format.
 * @param  mixed $email
 * @return void
 */
function emailCheck($email)
{
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    Print_r("Email format is invalid");
  } else {
    return true;
  }
}

/**
 * phoneCheck
 *This method is for checking phone number format.
 * @param  mixed $phone
 * @return void
 */
function phoneCheck($phone)
{
  if (preg_match("/^([0-9]{11})$/", $phone)) {
    return true;
  } else {
    Print_r("Phone number is not valid");
  }
}
?>