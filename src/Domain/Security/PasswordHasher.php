<?php

namespace App\Domain\Security;

interface PasswordHasher
{
    public function hash(string $password): string;
}
