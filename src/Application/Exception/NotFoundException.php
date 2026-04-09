<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Exception;

class NotFoundException extends Exception
{
    public function __construct(?string $message = null)
    {
        parent::__construct($message ?? ApiErrorCode::NOT_FOUND->value, ApiErrorCode::NOT_FOUND->getHttpStatusCode());
    }
}
