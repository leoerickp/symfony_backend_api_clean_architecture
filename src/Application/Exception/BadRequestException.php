<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BadRequestException extends HttpException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(ApiErrorCode::BAD_REQUEST->getHttpStatusCode(), $message ?? ApiErrorCode::BAD_REQUEST->value);
    }
}
