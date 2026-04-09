<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ErrorResponse extends JsonResponse
{
    /**
     * @param string $message
     * @param string[] $errors
     * @param int $status
     */
    public function __construct(
        string $message = 'Validation failed',
        array $errors = [],
        int $status = 400
    ) {
        parent::__construct([
            'success' => false,
            'statusCode' => $status,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
