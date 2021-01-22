<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Application\DepartmentService;
use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Department\Contracts\DepartmentRepositoryInterface;
use Laminas\Diactoros\ServerRequest;
use Hr\Domain\Department\DataMappers\DepartmentMapper;
use Hr\Infrastructure\Auth;
use Hr\Interfaces\API\Validators\DepartmentsValidator;

class DepartmentsController 
{
    /**
     * Holds the implementation of the repository.
     *  
     * @var \Hr\Domain\Department\Contracts\DepartmentRepositoryInterface
     */
    private $repository;

    /**
     * Creata new instance of DepartmentsController
     * 
     * @param \Hr\Domain\Department\Contracts\DepartmentRepositoryInterface 
     */
    public function __construct(Auth $auth, DepartmentRepositoryInterface $repository)
    {
        $auth->check();
        $this->repository = $repository;
    }
    
    /**
     * Fetch departments and filter them.
     * 
     * @return \Laminas\Diactoros\JsonResponse
     */
    public function index(ServerRequest $request)
    {
        $params = $request->getQueryParams(); 
         
        $departments = $this->repository->getAllWithSalaries($params);

        return Response::success($departments, 'Succesfully fetched departments',  200);
    }

    /**
     * Store the incoming department after validation.
     * 
     * @param \Laminas\Diactoros\ServerRequest 
     * @return \Laminas\Diactoros\JsonResponse
     */
    public function store(DepartmentsValidator $validator)
    {
        $data = $validator->validated;
        
        $department = $this->repository->save(DepartmentMapper::fromRequest($data));
        
        return Response::success($department, 'Succesfully created department',  201);
    }

    /**
     * Fetch a single department.
     * 
     * @param int $id The id of department to search for. 
     * @return \Laminas\Diactoros\JsonResponse
     */
    public function show($id)
    {
        $department = $this->repository->findById($id);

        if (empty($department)) {
            return Response::error([], 'Entity Not Found!', 404);
        }
        
        return Response::success($department, 'Succesfully fetched department',  200);
    }

    /**
     * Fetch a single department and update it.
     * 
     * @param \Laminas\Diactoros\ServerRequest 
     * @param int $id The id of department to search for. 
     * @return \Laminas\Diactoros\JsonResponse
     */
    public function update(DepartmentsValidator $validator, $id)
    {
        $data = $validator->validated;
        $this->repository->update(DepartmentMapper::fromRequest($data), $id);

        return Response::success(null, 'Succesfully updated department', 204);
    }

    /**
     * Fetch a single department and delete it.
     * 
     * @param int $id The id of department to search for. 
     * @return \Laminas\Diactoros\JsonResponse
     */
    public function destroy($id)
    {
        if ($this->repository->hasEmployees()) {
            return Response::success(null, 'Cannot delete a department that has employees!', 403); 
        }
        $this->repository->delete($id);
        
        return Response::success(null, 'Succesfully deleted department', 204);
    }
}