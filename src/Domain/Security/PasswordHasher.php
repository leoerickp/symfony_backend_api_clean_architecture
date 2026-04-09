<?php

declare(strict_types=1);

namespace App\Domain\Security;

interface PasswordHasher
{
    public function hash(string $password): string;
}
