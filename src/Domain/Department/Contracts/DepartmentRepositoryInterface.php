<?php

namespace Hr\Domain\Department\Contracts;

interface DepartmentRepositoryInterface 
{
    public function getAllWithSalaries(): ?array;


}