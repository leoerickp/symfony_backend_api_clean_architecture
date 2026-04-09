<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Dto\CreateUserDto;
use App\Application\Dto\LoginUserDto;
use App\Application\UseCase\User\CreateUserUseCase;
use App\Infrastructure\Http\Response\SuccessResponse;
use App\Application\UseCase\Auth\LoginUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class AuthController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly LoginUseCase $loginUseCase,
        private readonly CreateUserUseCase $createUserUseCase
    ) {
    }

    #[Route('/api/auth/register', name: 'app_auth_register', methods: ['POST'])]
    public function register(CreateUserDto $createUserDto): JsonResponse
    {
        $authenticatedUser = $this->createUserUseCase->execute($createUserDto->getFullName(), $createUserDto->getEmail(), $createUserDto->getPassword());
        return new SuccessResponse($this->serializer, $authenticatedUser);
    }

    #[Route('/api/auth/login', name: 'app_auth_login', methods: ['POST'])]
    public function login(LoginUserDto $loginUserDto): JsonResponse
    {
        $authenticatedUser = $this->loginUseCase->execute($loginUserDto->email, $loginUserDto->password);
        return new SuccessResponse($this->serializer, $authenticatedUser);
    }
}
