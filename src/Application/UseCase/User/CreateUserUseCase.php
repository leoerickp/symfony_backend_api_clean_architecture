<?php

declare(strict_types=1);

namespace App\Application\UseCase\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UnitOfWork;
use App\Domain\Repository\UserRepository;
use App\Domain\Security\TokenGenerator;
use App\Domain\Security\PasswordHasher;
use App\Application\Dto\UserResponseDto;

class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordHasher $passwordHasher,
        private readonly TokenGenerator $tokenGenerator,
        private readonly UnitOfWork $unitOfWork
    ) {
    }

    /**
     * @param string $fullName
     * @param string $email
     * @param string $password
     * @return array{token: string, user: UserResponseDto}
     */
    public function execute(string $fullName, string $email, string $password): array
    {
        $user = User::create($fullName, $email, $this->passwordHasher->hash($password));

        $this->userRepository->save($user);

        $this->unitOfWork->flush();

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
