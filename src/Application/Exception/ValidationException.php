<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Domain\Enum\ApiErrorCode;

class ValidationException extends \Exception
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
        parent::__construct($message ?? ApiErrorCode::BAD_REQUEST->value, $code ?? ApiErrorCode::BAD_REQUEST->getHttpStatusCode());
    }
}
