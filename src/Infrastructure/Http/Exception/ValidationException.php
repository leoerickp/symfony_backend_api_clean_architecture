<?php

namespace App\Infrastructure\Http\Exception;

class ValidationException extends \Exception
{
    public function __construct(
        public array $errors = [],
        string $message = 'BAD_REQUEST',
        int $code = 400
    ) {
        parent::__construct($message, $code);
    }
}
