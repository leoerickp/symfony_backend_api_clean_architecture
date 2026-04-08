<?php

namespace App\Application\UseCase\Auth;

use App\Domain\Entity\User;
use App\Application\Dto\UserResponseDto;
use App\Domain\Repository\UserRepository;
use App\Domain\Security\TokenGenerator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class LoginUseCase
{
    public function __construct(
        private UserRepository $userRepository,
        private JWTTokenManagerInterface $jwtManager,
        private TokenGenerator $tokenGenerator,
    ) {
    }

    public function execute(string $email, string $password): array
    {
        $user = $this->userRepository->findOneByEmail($email);
        /* if (!$user) {
            throw new UnauthorizedHttpException('Invalid credentials');
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
            'token' => $this->tokenGenerator->generate($user),
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
