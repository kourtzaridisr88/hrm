<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Department\Contracts\DepartmentRepositoryInterface;
use Hr\Domain\Department\Contracts\EmployeeRepositoryInterface;
use Hr\Infrastructure\Auth;

class ReportsController 
{
    /**
     * The departments repository implementation.
     * 
     * @var \Hr\Domain\Department\Contracts\DepartmentRepositoryInterface
     */
    private $departments;

    /**
     * The employees repository implementation.
     * 
     * @var \Hr\Domain\Department\Contracts\EmployeeRepositoryInterface
     */
    private $employees;

    /**
     * Create's new instance and check if the 
     * incoming request is authenticated.
     * 
     * @param \Hr\Infrastructure\Auth
     * @param \Hr\Domain\Department\Contracts\DepartmentRepositoryInterface
     * @param \Hr\Domain\Department\Contracts\EmployeeRepositoryInterface
     */
    public function __construct(
        Auth $auth,
        DepartmentRepositoryInterface $departments, 
        EmployeeRepositoryInterface $employees
    ) {
        $auth->check();
        $this->departments = $departments;
        $this->employees = $employees;
    }

    /**
     * Fetching the reports.
     * 
     * @return \Laminas\Diactoros\ResponseInterface
     */
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
