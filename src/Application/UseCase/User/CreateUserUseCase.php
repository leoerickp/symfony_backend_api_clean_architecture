<?php

namespace App\Application\UseCase\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Security\TokenGenerator;
use App\Domain\Security\PasswordHasher;
use App\Application\Dto\UserResponseDto;

class CreateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasher $passwordHasher,
        private TokenGenerator $tokenGenerator,
    ) {
    }

    public function execute(string $fullName, string $email, string $password): array
    {
        $user = User::create($fullName, $email, $this->passwordHasher->hash($password));

        $this->userRepository->save($user, true);

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
