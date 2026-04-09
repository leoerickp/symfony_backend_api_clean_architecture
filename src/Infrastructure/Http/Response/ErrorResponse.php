<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use App\Domain\Enum\ApiErrorCode;
use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
    /**
     * @param string $message
     * @param string[] $errors
     * @param int $status
     */
    public function __construct(
        ?string $message = null,
        array $errors = [],
        ?int $status = null
    ) {
        parent::__construct([
            'success' => false,
            'statusCode' => $status ?? ApiErrorCode::BAD_REQUEST->getHttpStatusCode(),
            'message' => $message ?? ApiErrorCode::BAD_REQUEST->value,
            'errors' => $errors
        ], $status);
    }
}
