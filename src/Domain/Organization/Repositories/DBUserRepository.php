<?php

namespace Hr\Domain\Organization\Repositories;

use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Hr\Infrastructure\Database\Database;
use Hr\Domain\Organization\Entities\User;

class DBUserRepository implements UserRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function save(User $user): array
    {
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        
        Database::instance()->execute($sql, [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $sql = "SELECT * FROM users WHERE id = LAST_INSERT_ID()";

        return Database::instance()->query($sql);
    }

    /**
     * {@inheritDoc}
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        return Database::instance()->query($sql, [
            'email' => $email
        ])[0] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function saveToken(int $id, string $token): void
    {
        $sql = "UPDATE users SET token = :token WHERE id = :id";

        Database::instance()->execute($sql, [
            'token' => $token,
            'id' => $id,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function findByToken(string $token): ?array
    {
        $sql = "SELECT * FROM users WHERE token = :token LIMIT 1";
        return Database::instance()->query($sql, [
            'token' => $token
        ])[0] ?? null;
    }
}