<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Application\DepartmentService;
use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Department\Contracts\EmployeeRepositoryInterface;
use Hr\Domain\Department\DataMappers\EmployeeMapper;
use Hr\Infrastructure\Auth;
use Hr\Interfaces\API\Validators\EmployeesValidator;

class EmployeesController
{
    private $repository;

    public function __construct(Auth $auth, EmployeeRepositoryInterface $repo)
    {
        $auth->check();
        $this->repo = $repo;
    }
    
    public function index()
    {
        $employees = $this->repo->paginate();

        return Response::success($employees, 'Succesfully fetched employees', 200);
    }

    public function store(EmployeesValidator $validator)
    {
        $employee = EmployeeMapper::fromRequest($validator->validated);
        $employee = $this->repo->save($employee);
        
        return Response::success($employee, 'Succesfully created employee', 201);
    }

    public function show($id)
    {
        $employee = $this->repo->findById($id);

        return Response::success($employee, 'Succesfully fetched employee', 200);
    }

    public function update(EmployeesValidator $validator, $id)
    {
        $data = $validator->validated;
        $data['id'] = $id;

        $this->repo->update(EmployeeMapper::fromRequest($data));

        return Response::empty();
    }

    public function destroy($id)
    {
        $this->repo->delete($id);

        return Response::empty();
    }
}