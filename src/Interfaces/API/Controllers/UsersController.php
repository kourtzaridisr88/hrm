<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Hr\Domain\Organization\DataMappers\UserMapper;
use Respect\Validation\Validator;
use Laminas\Diactoros\ServerRequest;
use Hr\Interfaces\API\Validators\UserValidator;

class UsersController 
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(UserValidator $validator)
    {
        $user = UserMapper::fromRequest($validator->validated);        
        $user = $this->repository->save($user);

        return Response::success($user, 'Succesfully created user', 201);
    }
}