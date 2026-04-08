<?php

namespace App\Application\Dto;

class UserResponseDto
{
    public function __construct(
        public string $id,
        public string $fullName,
        public string $email,
        public array $roles,
    ) {
    }
}
