<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DuplicateResourceException extends HttpException
{
    public function __construct(?string $message = null, public ?string $field = null)
    {
        parent::__construct(ApiErrorCode::DUPLICATE_ENTRY->getHttpStatusCode(), $message ?? ApiErrorCode::DUPLICATE_ENTRY->value);
    }
}
