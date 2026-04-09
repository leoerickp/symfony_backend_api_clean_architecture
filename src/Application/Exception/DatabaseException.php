<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Exception;

class DatabaseException extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? ApiErrorCode::DATABASE_ERROR->value, ApiErrorCode::DATABASE_ERROR->getHttpStatusCode());
    }
}
