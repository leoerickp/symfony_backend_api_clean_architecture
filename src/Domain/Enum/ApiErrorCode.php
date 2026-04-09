<?php

declare(strict_types=1);

namespace App\Domain\Enum;

enum ApiErrorCode: string
{
    case BAD_REQUEST = 'BAD_REQUEST_ERROR';
    case DUPLICATE_ENTRY = 'DUPLICATE_ENTITY_ERROR';
    case VALIDATION_FAILED = 'VALIDATION_FAILED_ERROR';
    case FOREIGN_KEY_ERROR = 'FOREIGN_KEY_VIOLATION_ERROR';
    case NOT_FOUND = 'RESOURCE_NOT_FOUND_ERROR';
    case UNAUTHORIZED = 'UNAUTHORIZED_ACCESS_ERROR';
    case FORBIDDEN = 'FORBIDDEN_ACCESS_ERROR';
    case INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    case DATABASE_ERROR = 'DATABASE_ERROR';

    public function getHttpStatusCode(): int
    {
        return match ($this) {
            self::BAD_REQUEST,
            self::VALIDATION_FAILED => 400,
            self::DUPLICATE_ENTRY,
            self::FOREIGN_KEY_ERROR => 409,
            self::NOT_FOUND => 404,
            self::UNAUTHORIZED => 401,
            self::FORBIDDEN => 403,
            self::DATABASE_ERROR,
            self::INTERNAL_SERVER_ERROR => 500,
        };
    }
}
