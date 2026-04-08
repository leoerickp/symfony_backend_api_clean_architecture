<?php

namespace App\Application\UseCase\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Security\TokenGenerator;
use App\Application\Dto\UserResponseDto;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class CreateUserUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
        private JWTTokenManagerInterface $jwtManager,
        private TokenGenerator $tokenGenerator,
    ) {
    }

    public function execute(string $fullName, string $email, string $password): array
    {
        $user = new User();
        $user->setFullName($fullName);
        $user->setEmail($email);
        $user->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash($password));
        $user->setRoles(['ROLE_USER']);

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
