<?php

namespace Hr\Domain\Organization\DataMappers;

use Hr\Domain\Organization\Entities\User;

class UserMapper
{
    public static function fromRequest(array $data): User
    {
        $user = new User();

        $user->id = $data['id'] ?? null;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_BCRYPT);

        return $user;
    }
}