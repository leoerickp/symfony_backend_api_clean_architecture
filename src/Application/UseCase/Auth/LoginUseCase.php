<?php

namespace App\Application\UseCase\Auth;

use App\Application\Dto\UserResponseDto;
use App\Domain\Repository\UserRepository;
use App\Domain\Security\TokenGenerator;

class LoginUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private TokenGenerator $tokenGenerator,
    ) {
    }

    public function execute(string $email, string $password): array
    {
        $user = $this->userRepository->findOneByEmail($email);

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
