<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class SuccessResponse extends JsonResponse
{
    /**
     * @param SerializerInterface $serializer
     * @param mixed $data
     * @param array<string, mixed> $meta
     * @param int $status
     */
    public function __construct(
        SerializerInterface $serializer,
        mixed $data = null,
        array $meta = [],
        int $status = 200
    ) {
        $json = $serializer->serialize([
            'success' => true,
            'statusCode' => $status,
            'data' => $data,
            'meta' => $meta
        ], 'json');
        parent::__construct($json, $status, [], true);
    }
}
