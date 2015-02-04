<?php

namespace Omnipay\Ideal\Exception;
use Omnipay\Common\Exception\OmnipayException;

/**
 * Error Response exception.
 */
class ErrorResponseException extends \Exception implements OmnipayException
{
    public function __construct($message = "Error response from payment gateway", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
