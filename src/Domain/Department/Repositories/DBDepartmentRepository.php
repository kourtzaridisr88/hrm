<?php

namespace Hr\Domain\Department\Repositories;

use Hr\Domain\Department\Contracts\DepartmentRepositoryInterface;
use Hr\Domain\Department\DataMappers\DepartmentMapper;
use Hr\Domain\Department\Entities\Department;
use Hr\Infrastructure\Database\Database;

class DBDepartmentRepository implements DepartmentRepositoryInterface
{   
    /**
     * {@inheritDoc}
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) AS total_departments from departments";

        return Database::instance()->query($sql)[0]['total_departments'] ?? 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllWithSalaries($params = []): ?array
    {
        $perPage = $params['per_page'] ?? 15;
        $page = $params['page'] ?? 1;
        $params['no_of_employees'] = $params['no_of_employees'] ?? 0;
        unset($params['per_page']);
        unset($params['page']);

        $sql = "SELECT departments.*, COUNT(employees.id) AS employees, MAX(employees.salary) as max_salary, 
            AVG(employees.salary) as avg_salaries, SUM(employees.salary) AS total_salaries 
            FROM departments 
            LEFT JOIN employees ON employees.department_id = departments.id GROUP BY departments.id HAVING employees >= :no_of_employees";

        if (isset($params['salaries_from'])) {
            $sql .= " AND total_salaries >= :salaries_from";
        }

        if (isset($params['salaries_to'])) {
            $sql .= " AND total_salaries < :salaries_to";
        }

        if ($perPage !== '*') {
            $skip = $perPage * ($page - 1);
            $limit = $skip + $perPage;
            $sql .= " LIMIT {$skip}, {$limit}";
        }

        $departments = Database::instance()->query($sql, $params);

        if ($perPage === '*') {
            return $departments;
        }

        $totalResults = (int) $this->count();

        return [
            'departments' => $departments,
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
    public function save(Department $department)
    {
        $sql = "INSERT INTO departments (name) VALUES (:name)";

        Database::instance()->execute($sql, [
            'name' => $department->name
        ]);

        $sql = "SELECT * FROM departments WHERE id = LAST_INSERT_ID()";

        return Database::instance()->query($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Department $department): void
    {
        $sql = "UPDATE departments SET name = :name WHERE id = :id";

        Database::instance()->execute($sql, [
            'id' => $department->id,
            'name' => $department->name
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id): Department
    {
        $sql = "SELECT departments.*, employees.name as employee_name, employees.salary, employees.position 
            FROM departments 
            LEFT JOIN employees ON employees.department_id = departments.id
            WHERE departments.id = :id";

        $rows = Database::instance()->query($sql, ['id' => $id]); 

        return DepartmentMapper::mapSingle($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function hasEmployees($id): bool
    {
        $sql = "SELECT departments.*,
            FROM departments 
            INNER JOIN employees ON employees.department_id = departments.id
            WHERE departments.id = :id";

        $rows = Database::instance()->query($sql, ['id' => $id]);

        return count($rows) > 0;
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id): void
    {
        $sql = "DELETE FROM departments WHERE id = :id";

        Database::instance()->execute($sql, ['id' => $id]);
    }
}