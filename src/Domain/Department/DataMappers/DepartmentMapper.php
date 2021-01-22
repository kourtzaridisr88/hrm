<?php

namespace Hr\Domain\Department\DataMappers;

use Hr\Domain\Department\Entities\Department;
use Hr\Domain\Department\Entities\Employee;

class DepartmentMapper
{
    public static function mapSingle($rows)
    {
        if (empty($rows)) return null;
        
        $department = new Department();

        foreach ($rows as $key => $row) {
            $employee = new Employee();

            $employee->id = $row['id'];
            $employee->name = $row['employee_name'];
            $employee->salary = $row['salary'];
            $employee->position = $row['position'];

            if (isset($department->id)) {
                array_push($department->employees, $employee); 
            } else {
                $department->id = $row['id'];
                $department->name = $row['name'];
                array_push($department->employees, $employee);
            }
        }

        return $department;
    }

    public static function fromRequest(array $body)
    {
        $department = new Department();

        $department->name = $body['name'];

        return $department;
    }
}