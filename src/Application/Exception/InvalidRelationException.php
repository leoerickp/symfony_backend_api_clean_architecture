<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Exception;

class InvalidRelationException extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? ApiErrorCode::FOREIGN_KEY_ERROR->value, ApiErrorCode::FOREIGN_KEY_ERROR->getHttpStatusCode());
    }
}
