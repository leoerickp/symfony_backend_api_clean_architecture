<?php

namespace App\Data;

class UserData
{
    public static function get(): array
    {
        return [
            [
                'email' => 'test1@google.com',
                'fullName' => 'Test One',
                'password' => 'Abc123',
                'roles' => ['ROLE_ADMIN']
            ],
            [
                'email' => 'test2@google.com',
                'fullName' => 'Test Two',
                'password' => 'Abc123',
                'roles' => ['ROLE_USER', 'ROLE_SUPER']
            ]
        ];
    }
}
