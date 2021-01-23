<?php

namespace Hr\Domain\Department\DataMappers;

use Hr\Domain\Department\Entities\Employee;

class EmployeeMapper
{
    /**
     * Create a new employee
     * 
     * @param array $data
     * @return \Hr\Domain\Department\Entities\Employee
     */
    public static function fromRequest(array $data): Employee
    {
        $employee = new Employee();

        $employee->id = $data['id'] ?? null;
        $employee->name = $data['name'];
        $employee->position = $data['position'];
        $employee->salary = $data['salary'];
        $employee->departmentID = $data['department_id'];

        return $employee;
    }
}
