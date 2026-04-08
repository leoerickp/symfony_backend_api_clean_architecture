<?php

namespace App\Application\Exception;

class ValidationException extends \Exception
{
    /**
     * Summary of __construct
     * @param string[] $errors
     * @param string $message
     * @param int $code
     */
    public function __construct(
        public array $errors = [],
        string $message = 'BAD_REQUEST',
        int $code = 400
    ) {
        parent::__construct($message, $code);
    }
}
