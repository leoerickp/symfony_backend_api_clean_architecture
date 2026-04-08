<?php

namespace App\Application\Dto;

class UserResponseDto
{
    /**
     * Summary of __construct
     * @param string $id
     * @param string $fullName
     * @param string $email
     * @param string[] $roles
     */
    public function __construct(
        public string $id,
        public string $fullName,
        public string $email,
        public array $roles,
    ) {
    }
}
