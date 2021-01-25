<?php

namespace Hr\Domain\Department\DataMappers;

use Hr\Domain\Department\Entities\Department;
use Hr\Domain\Department\Entities\Employee;

class DepartmentMapper
{
    /**
     * Given an array of database rows 
     * create's a department and employees
     * 
     * @param array $rows
     * @return \Hr\Domain\Department\Entities\Department
     */
    public static function mapSingle($rows): Department
    {
        if (empty($rows)) return null;
        
        $department = new Department();

        foreach ($rows as $key => $row) {
            $employee = new Employee();

            $employee->id = (int) $row['id'];
            $employee->name = $row['employee_name'];
            $employee->salary = $row['salary'];
            $employee->position = $row['position'];

            if (isset($department->id)) {
                array_push($department->employees, $employee); 
            } else {
                $department->id = (int) $row['id'];
                $department->name = $row['name'];
                array_push($department->employees, $employee);
            }
        }

        return $department;
    }

    /**
     * Create a new department
     * 
     * @param array $data
     * @return \Hr\Domain\Department\Entities\Department
     */
    public static function fromRequest(array $data): Department
    {
        $department = new Department();

        $department->id = isset($data['id']) ? (int) $data['id'] : null; 
        $department->name = $data['name'];

        return $department;
    }
}