<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use App\Domain\Security\PasswordHasher;
use App\Domain\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class PasswordHasser implements PasswordHasher
{
    public function __construct(
        private readonly PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    public function hash(string $password): string
    {
        return $this->passwordHasherFactory->getPasswordHasher(User::class)->hash($password);
    }
}
