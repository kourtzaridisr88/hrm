<?php

namespace Hr\Infrastructure;

use Laminas\Diactoros\ServerRequest;
use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Exception;

class Auth
{
    private $request;
    private $repository;
    public $user;

    public function __construct(ServerRequest $request, UserRepositoryInterface $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    public function check()
    {
        $bearer = $this->request->getHeaderLine('Authorization');
        
        if (empty($bearer)) {
            throw new Exception('Authorization header does not exist');
        }
        $token = explode(' ', $bearer)[1];
        
        $user = $this->repository->findByToken($token);
        
        if ($user === null) {
            throw new Exception('Token does not exist!');
        }

        $this->user = $user;
    }
}