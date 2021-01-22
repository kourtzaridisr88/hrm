<?php

namespace Hr\Infrastructure;

use Laminas\Diactoros\ServerRequest;
use Hr\Infrastructure\Foundation\Response;
use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Exception;

class Auth
{
    /**
     * The incoming request handler.
     * 
     * @var \Laminas\Diactoros\ServerRequest
     */
    private $request;

    /**
     * The users database abstraction.
     * 
     * @var \Hr\Domain\Organization\Contracts\UserRepositoryInterface
     */
    private $repository;

    /**
     * The current authenticated user.
     * 
     * @var
     */
    public $user;

    /**
     * Create new instance.
     * 
     * @param $request \Laminas\Diactoros\ServerRequest
     * @param $repository \Hr\Domain\Organization\Contracts\UserRepositoryInterface
     */
    public function __construct(ServerRequest $request, UserRepositoryInterface $repository)
    {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Check if the incoming request is authenticated.
     * 
     */
    public function check(): void
    {
        $token = $this->bearerExists();
        $this->findUser($token);
    }

    /**
     * Check if bearer token exist in incoming request.
     * 
     * @throws Exception
     * @return string
     */
    public function bearerExists(): string
    {
        $bearer = $this->request->getHeaderLine('Authorization');
        
        if (empty($bearer)) {
            throw new Exception('Authorization header does not exist');
        }

        return explode(' ', $bearer)[1];
    }

    /**
     * Check if user exists by given token.
     * 
     * @param string $token
     * @throws Exception
     * @return string
     */
    public function findUser($token)
    {
        $user = $this->repository->findByToken($token);
        
        if ($user === null) {
            throw new Exception('Token does not exist!');
        }

        $this->user = $user;
    }
}