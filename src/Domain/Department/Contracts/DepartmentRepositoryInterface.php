<?php

namespace Hr\Domain\Department\Contracts;

use Hr\Domain\Department\Entities\Department;

interface DepartmentRepositoryInterface 
{
    /**
     * Count's the departments.
     */
    public function count();

    /**
     * Fetch departments and aggregate salaries.
     * 
     * @param array $params The params to query the departments.
     */
    public function getAllWithSalaries($params = []): ?array;

    /**
     * Store's the given department
     * 
     * @param \Hr\Domain\Department\Entities\Department
     */
    public function save(Department $department);

    /**
     * Update's the given department
     * 
     * @param \Hr\Domain\Department\Entities\Department
     */
    public function update(Department $department): void;

    /**
     * Find a department by id
     * 
     * @param id
     * @return \Hr\Domain\Department\Entities\Department
     */
    public function findById($id): Department;

    /**
     * Check's if department has employees
     * 
     * @param id
     * @return bool
     */
    public function hasEmployees($id): bool;

    /**
     * Delete's the given department
     * 
     * @param int
     */
    public function delete($id): void;
}