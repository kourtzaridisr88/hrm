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
    /**
     * The users repository implementation.
     * 
     * @var \Hr\Domain\Organization\Contracts\UserRepositoryInterface
     */
    private $repository;

    /**
     * Create's new instance.
     * 
     * @param \Hr\Domain\Organization\Contracts\UserRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a user to the database.
     * 
     * @param \Hr\Interfaces\API\Validators\UserValidator
     * @return \Laminas\Diactoros\ResponseInterface
     */
    public function store(UserValidator $validator)
    {
        $user = UserMapper::fromRequest($validator->validated);        
        $user = $this->repository->save($user);

        return Response::success($user, 'Succesfully created user', 201);
    }
}