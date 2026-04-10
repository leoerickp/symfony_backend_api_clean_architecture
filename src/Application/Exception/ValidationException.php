<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidationException extends HttpException
{
    /**
     * @param string[] $errors
     * @param string $message
     * @param int $code
     */
    public function __construct(
        public array $errors = [],
        ?string $message = null,
        ?int $code = null
    ) {
        parent::__construct(ApiErrorCode::BAD_REQUEST->getHttpStatusCode(), $message ?? ApiErrorCode::BAD_REQUEST->value);
    }
}
