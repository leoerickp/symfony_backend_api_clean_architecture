<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Listener;

use App\Infrastructure\Http\Response\ErrorResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\Response;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $response = new ErrorResponse('UNAUTHORIZED', ['Missing JWT Token'], Response::HTTP_UNAUTHORIZED);

        $event->setResponse($response);
    }
}
