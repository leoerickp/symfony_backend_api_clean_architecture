<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Exception;

class DuplicateResourceException extends Exception
{
    public function __construct(?string $message = null, public ?string $field = null)
    {
        parent::__construct($message ?? ApiErrorCode::DUPLICATE_ENTRY->value, ApiErrorCode::DUPLICATE_ENTRY->getHttpStatusCode());
    }
}
