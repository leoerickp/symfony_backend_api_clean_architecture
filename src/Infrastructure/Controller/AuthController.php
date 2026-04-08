<?php

namespace App\Infrastructure\Controller;

use App\Application\Dto\CreateUserDto;
use App\Application\Dto\LoginUserDto;
use App\Service\AuthService;
use App\Infrastructure\Http\Response\SuccessResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class AuthController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private readonly AuthService $authService
    ) {
    }

    #[Route('/api/auth/register', name: 'app_auth_register', methods: ['POST'])]
    public function register(CreateUserDto $createUserDto): JsonResponse
    {
        $loggedUser = $this->authService->create($createUserDto->getFullName(), $createUserDto->getEmail(), $createUserDto->getPassword());
        return new SuccessResponse($this->serializer, $loggedUser);
    }

    #[Route('/api/auth/login', name: 'app_auth_login', methods: ['POST'])]
    public function login(LoginUserDto $loginUserDto): JsonResponse
    {
        $loggerUser = $this->authService->login($loginUserDto->getEmail(), $loginUserDto->getPassword());
        return new SuccessResponse($this->serializer, $loggerUser);
    }
}
