<?php

declare(strict_types=1);

namespace App\Application\Dto;

final readonly class UserResponseDto
{
    /**
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
