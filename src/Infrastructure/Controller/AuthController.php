<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Dto\CreateUserDto;
use App\Application\Dto\LoginUserDto;
use App\Application\UseCase\Auth\CheckStatusUseCase;
use App\Application\UseCase\User\CreateUserUseCase;
use App\Infrastructure\Http\Response\SuccessResponse;
use App\Application\UseCase\Auth\LoginUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

final class AuthController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly LoginUseCase $loginUseCase,
        private readonly CreateUserUseCase $createUserUseCase,
        private readonly CheckStatusUseCase $checkStatusUseCase,
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
    #[IsGranted('ROLE_USER')]
    #[Route('/api/auth/check-status', name: 'app_auth_check_status', methods: ['GET'])]
    public function checkStatus(): JsonResponse
    {
        $user = $this->getUser();
        $authenticatedUser = $this->checkStatusUseCase->execute($user);
        return new SuccessResponse($this->serializer, $authenticatedUser);
    }
}
