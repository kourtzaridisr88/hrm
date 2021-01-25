<?php

namespace Hr\Domain\Department\Contracts;

use Hr\Domain\Department\Entities\Employee;

interface EmployeeRepositoryInterface 
{
    /**
     * Paginate employees results.
     * 
     * @param int $perPage
     * @param int $page
     * @return array
     */
    public function paginate($perPage = 15, $page = 1): array;

    /**
     * Count employees entries.
     * 
     * @return string|null
     */
    public function count(): ?string;

    /**
     * Sumarize employees salaries.
     * 
     * @return array|null
     */
    public function countTotalSalaries(): ?int;

    /**
     * Store an employee.
     * 
     * @param \Hr\Domain\Deprtment\Entities\Employee
     * @return array
     */
    public function save(Employee $employee): array;

    /**
     * Update an empoyee.
     * 
     * @param \Hr\Domain\Deprtment\Entities\Employee
     * @return void
     */
    public function update(Employee $employee): void;

    /**
     * Search an empoyee by his id.
     * 
     * @param \Hr\Domain\Deprtment\Entities\Employee
     * @return void
     * @throws \Hr\Infrastructure\Exception\EntityNotFoundException
     */
    public function findById(int $id): array;

    /**
     * Delete an empoyee by his id.
     * 
     * @param \Hr\Domain\Deprtment\Entities\Employee
     * @return void
     */
    public function delete(int $id): void;
}