<?php

declare(strict_types=1);

namespace App\Application\UseCase\Auth;

use App\Application\Dto\UserResponseDto;
use App\Domain\Security\TokenGenerator;
use App\Domain\Entity\User;

class CheckStatusUseCase
{
    public function __construct(
        private readonly TokenGenerator $tokenGenerator,
    ) {
    }

    /**
     * @param User $user
     * @return array{token: string, user: UserResponseDto}
     */
    public function execute(User $user): array
    {
        return [
            'user' => new UserResponseDto(
                $user->getId(),
                $user->getFullName(),
                $user->getEmail(),
                $user->getRoles()
            ),
            'token' => $this->tokenGenerator->generate($user),
        ];
    }
}
