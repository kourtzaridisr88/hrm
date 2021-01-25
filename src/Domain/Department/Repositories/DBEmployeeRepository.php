<?php

namespace Hr\Domain\Department\Repositories;

use Hr\Domain\Department\Contracts\EmployeeRepositoryInterface;
use Hr\Domain\Department\DataMappers\EmployeeMapper;
use Hr\Domain\Department\Entities\Employee;
use Hr\Infrastructure\Database\Database;
use Hr\Infrastructure\Exceptions\EntityNotFoundException;

class DBEmployeeRepository implements EmployeeRepositoryInterface
{   
    /**
     * {@inheritDoc}
     */
    public function paginate($perPage = 15, $page = 1): array
    {
        $sql = "SELECT * from employees";
        $results = Database::instance()->query($sql);
        $totalResults = (int) $this->count();

        return [
            'employees' => $results,
            'pagination' => [
                'total' => $totalResults,
                'per_page' => $perPage,
                'page' => $page,
                'total_pages' => ceil($totalResults / $perPage)  
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function count(): ?string
    {
        $sql = "SELECT COUNT(*) AS total_employees FROM employees";

        return Database::instance()->query($sql)[0]['total_employees'] ?? 0;
    }

    /**
     * {@inheritDoc}
     */
    public function countTotalSalaries(): ?int
    {
        $sql = "SELECT SUM(salary) AS total_salaries FROM employees";

        return Database::instance()->query($sql)[0]['total_salaries'] ?? 0;
    }

    /**
     * {@inheritDoc}
     */
    public function save(Employee $employee): array
    {
        $sql = "INSERT INTO employees (name, position, salary, department_id) VALUES (:name, :position, :salary, :department_id)";
        
        Database::instance()->execute($sql, [
            'name' => $employee->name,
            'position' => $employee->position,
            'salary' => $employee->salary,
            'department_id' => $employee->departmentID
        ]);

        $sql = "SELECT * FROM employees WHERE id = LAST_INSERT_ID()";

        return Database::instance()->query($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Employee $employee): void
    {
        $sql = "UPDATE employees SET name = :name, position = :position, salary = :salary, department_id = :department_id WHERE id = :id";

        Database::instance()->execute($sql, [
            'id' => $employee->id,
            'name' => $employee->name,
            'position' => $employee->position,
            'salary' => $employee->salary,
            'department_id' => $employee->departmentID
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id): array
    {
        $sql = "SELECT * FROM employees WHERE id = :id";

        $rows = Database::instance()->query($sql, ['id' => (int) $id]);

        if (empty($rows)) throw new EntityNotFoundException();
        
        return $rows[0];
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id): void
    {
        $sql = "DELETE FROM employees WHERE id = :id";

        Database::instance()->execute($sql, ['id' => $id]);
    }
}