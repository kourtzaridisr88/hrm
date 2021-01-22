<?php

namespace Hr\Infrastructure\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public $errors = [];
    public $code = 422;
    public $message = 'Validation Failed!';

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }
}