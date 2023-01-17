<?php

namespace ShurjopayPlugin;

use Throwable;

/**
 * This php file contains a custom exception class
 * Here , a constructor is used for get throwing string , exception instance and others
 * Inside that constructor customFunction() and exceptionInfo() called
 * Here exceptionInfo() method used from ExceptionInfoService trait
 *
 * @author Rayhan Khan Ridoy
 * @since 2022-12-01
 */
class ShurjopayException extends \Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, $e = null, Throwable $previous = null)
    {
        $this->customFunction();
        $this->exceptionInfo($message, $e);
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);

    }

// This is a method which prints a default exception for every custom exception message.
    public function customFunction()
    {
        echo "<u> <br> <h3> A ShurjoPay Message For This Type Of Exception :- </h3>  </u>";
    }

    public function exceptionInfo($message, $e)
    {

        $System_error_msg = $e->getMessage();
        $shurjopay_help = $message;
        $problem_file_name = $e->getFile();
        $problem_LineNumber = $e->getLine();
        $myResponse = ["System_error_msg" => $System_error_msg, "shurjopay_help" => $shurjopay_help, "problem_file_name" => $problem_file_name, "problem_LineNumber" => $problem_LineNumber];

        foreach ($myResponse as $attribute => $value) {
            echo $attribute . "=>" . $value . "<br>";
        }
        exit;
    }


}
