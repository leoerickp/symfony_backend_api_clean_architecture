<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Listener;

use App\Domain\Enum\ApiErrorCode;
use App\Infrastructure\Http\Response\ErrorResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

class JWTNotFoundListener
{
    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $response = new ErrorResponse(ApiErrorCode::UNAUTHORIZED->value, ['Missing JWT Token'], ApiErrorCode::UNAUTHORIZED->getHttpStatusCode());

        $event->setResponse($response);
    }
}
