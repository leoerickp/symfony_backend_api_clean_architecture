<?php

namespace App\Infrastructure\Security;

use App\Domain\Security\TokenGenerator;
use App\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class JwtTokenGenerator implements TokenGenerator
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function generate(User $user): string
    {
        return $this->jwtManager->createFromPayload($user, [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ]);
    }
}
