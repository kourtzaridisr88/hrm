<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Department\Contracts\DepartmentRepositoryInterface;
use Hr\Domain\Department\Contracts\EmployeeRepositoryInterface;
use Hr\Infrastructure\Auth;

class ReportsController 
{
    private $departments;
    private $employees;

    public function __construct(
        Auth $auth,
        DepartmentRepositoryInterface $departments, 
        EmployeeRepositoryInterface $employees
    ) {
        $auth->check();
        $this->departments = $departments;
        $this->employees = $employees;
    }

    public function index()
    {
        $departments = $this->departments->count();
        $employees = $this->employees->count();
        $totalSalaries = $this->employees->countTotalSalaries();
        
        return Response::success([
            'departments' => $departments,
            'employees' => $employees,
            'total_salaries' => $totalSalaries
        ], 'Succesfully fetched reports',  201);
    }
}
