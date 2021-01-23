<?php

namespace Hr\Domain\Organization\Entities;

class User
{
    /**
     * The unique user id.
     * 
     * @var int 
     */
    public $id;

    /**
     * The user name.
     * 
     * @var string 
     */
    public $name;

    /**
     * The user email.
     * 
     * @var string 
     */
    public $email;

    /**
     * The user password.
     * 
     * @var string 
     */
    public $password; 
}