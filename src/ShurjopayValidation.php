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
 * @param mixed $payload_data
 * This is a validation method whitch has all of payload data and it sends data for null & formate validation.
 */
function Validation($payload_data)
{
    $payload_data = (json_decode($payload_data));

    return (
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
            'Discount percentage',
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
    );
}


/**
 * Checks whether a data item is null or empty.
 *
 * @param mixed $type
 * @param mixed $data
 * @return void
 */
function emptyCheck($type, $data)
{
 
    if ($data == null || $data == "") {
        print_r("$type is null or empty");
    } else {
        return true;
    }
}

/**
 * Checks for valid email format.
 * @param mixed $email
 * @return void
 */
function emailCheck($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        print_r("Email format is invalid");
    } else {
        return true;
    }
}

/**
 * This method is for checking phone number format.
 * @param mixed $phone
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