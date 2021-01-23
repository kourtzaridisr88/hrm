<?php

namespace Hr\Domain\Organization\Contracts;

use Hr\Domain\Organization\Entities\User;

interface UserRepositoryInterface 
{
    /**
     * Save's a user.
     * 
     * @param \Domain\Organization\Entities\User
     * @return array
     */
    public function save(User $user): array;

    /**
     * Search a user by his email.
     * 
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array;

    /**
     * Save a token to the user.
     * 
     * @param int id
     * @param string token
     */
    public function saveToken(int $id, string $token): void;

    /**
     * Search a user by his token.
     * 
     * @param string token
     * @return array|null
     */
    public function findByToken(string $token): ?array;
}