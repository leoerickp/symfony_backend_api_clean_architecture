<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DatabaseException extends HttpException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(ApiErrorCode::DATABASE_ERROR->getHttpStatusCode(), $message ?? ApiErrorCode::DATABASE_ERROR->value);
    }
}
