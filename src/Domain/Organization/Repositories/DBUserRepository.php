<?php

namespace Hr\Domain\Organization\Repositories;

use Hr\Domain\Organization\Contracts\UserRepositoryInterface;
use Hr\Infrastructure\Database\Database;
use Hr\Domain\Organization\Entities\User;

class DBUserRepository implements UserRepositoryInterface
{
    public function save(User $user)
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

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        return Database::instance()->query($sql, [
            'email' => $email
        ])[0] ?? null;
    }

    public function saveToken($id, $token)
    {
        $sql = "UPDATE users SET token = :token WHERE id = :id";

        Database::instance()->execute($sql, [
            'token' => $token,
            'id' => $id,
        ]);
    }

    public function findByToken($token)
    {
        $sql = "SELECT * FROM users WHERE token = :token LIMIT 1";
        return Database::instance()->query($sql, [
            'token' => $token
        ])[0] ?? null;
    }
}