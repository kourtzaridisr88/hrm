<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Hr\Interfaces\API\Validators\AuthValidator;

class LoginController 
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
     * Loggin users to the app.
     * 
     * @param \Hr\Interfaces\API\Validators\AuthValidator
     */
    public function store(AuthValidator $validator)
    {
        $email = $validator->validated['email'];
        $password = $validator->validated['password'];

        $user = $this->repository->findByEmail($email);

        if ($user === null) {
            return Response::error([], 'Email does not exist!', 422);
        }

        $auth = password_verify($password, $user['password']);

        if (!$auth) {
            return Response::error([], 'Password does not match!', 422);
        }

        $token = base64_encode("{$user['email']}.{$user['password']}");
        $this->repository->saveToken($user['id'], $token);
        $user['token'] = $token;
        
        return Response::success($user, 'Succesfully logged in!!',  201);
    }
}
