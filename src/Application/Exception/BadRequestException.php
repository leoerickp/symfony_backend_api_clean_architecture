<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Exception;

class BadRequestException extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? ApiErrorCode::BAD_REQUEST->value, ApiErrorCode::BAD_REQUEST->getHttpStatusCode());
    }
}
