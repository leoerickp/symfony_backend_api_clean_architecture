<?php

namespace App\Service;

use App\Application\Dto\UserResponseDto;
use App\Domain\Repository\UserRepository;
use App\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AuthService
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
        private UserRepository $userRepository,
    ) {
    }

    public function create(string $fullName, string $email, string $password): array
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
            'token' => $this->generateToken($user),
        ];
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findOneByEmail($email);
        /* if (!$user) {
            throw new UnauthorizedHttpException('Invalid credentials2');
        }

        if (!password_verify($password, $user->getPassword())) {
            throw new UnauthorizedHttpException('Invalid credentials');
        } */

        return [
            'user' => new UserResponseDto(
                $user->getId(),
                $user->getFullName(),
                $user->getEmail(),
                $user->getRoles()
            ),
            'token' => $this->generateToken($user),
        ];
    }

    private function generateToken(User $user): string
    {
        return $this->jwtManager->createFromPayload($user, [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ]);
    }
}
