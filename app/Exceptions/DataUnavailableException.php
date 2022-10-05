<?php

namespace App\Exceptions;

use Exception;

class DataUnavailableException extends Exception
{
    public function __construct($message, $code, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}