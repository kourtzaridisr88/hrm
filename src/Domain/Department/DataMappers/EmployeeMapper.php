<?php

namespace Hr\Domain\Department\DataMappers;

use Hr\Domain\Department\Entities\Employee;

class EmployeeMapper
{
    public static function fromRequest(array $data)
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
