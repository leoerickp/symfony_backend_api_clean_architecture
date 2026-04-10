<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NotFoundException extends HttpException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(ApiErrorCode::NOT_FOUND->getHttpStatusCode(), $message ?? ApiErrorCode::NOT_FOUND->value);
    }
}
