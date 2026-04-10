<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InvalidRelationException extends HttpException
{
    public function __construct(?string $message = null)
    {
        parent::__construct(ApiErrorCode::FOREIGN_KEY_ERROR->getHttpStatusCode(), $message ?? ApiErrorCode::FOREIGN_KEY_ERROR->value);
    }
}
