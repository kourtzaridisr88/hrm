<?php

namespace Hr\Domain\Department\Entities;

class Employee
{
    /**
     * The unique employee id.
     * 
     * @var int 
     */
    public $id;

    /**
     * The employee's name.
     * 
     * @var string
     */
    public $name;

    /**
     * The employee's position.
     * 
     * @var string
     */
    public $position;

    /**
     * The employee's salary.
     * 
     * @var string
     */
    public $salary;

    /**
     * The employee's belonging department id.
     * 
     * @var int
     */
    public $departmentID;
}