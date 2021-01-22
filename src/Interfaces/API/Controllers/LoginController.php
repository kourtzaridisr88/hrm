<?php

namespace Hr\Interfaces\API\Controllers;

use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Hr\Interfaces\API\Validators\AuthValidator;

class LoginController 
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

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

    public function logout($id)
    {
        $this->repository->saveToken($id, null);
    }
}
