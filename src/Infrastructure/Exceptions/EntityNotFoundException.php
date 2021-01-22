<?php

namespace Hr\Infrastructure\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    public function __construct() 
    {
        parent::__construct('Entity Not Found!', 404);
    }
}