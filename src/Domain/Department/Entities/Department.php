<?php

namespace Hr\Domain\Department\Entities;

class Department
{
    /**
     * The unique id.
     * 
     * @var int
     */
    public $id;

    /**
     * The department name.
     * 
     * @var string
     */
    public $name;

    /**
     * The department emmployees.
     * 
     * @var array
     */
    public $employees = [];
}