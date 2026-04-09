<?php

declare(strict_types=1);

namespace App\Application\Exception;

use Exception;

class BadRequestException extends Exception
{
    public function __construct(string $message = "Bad request", int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
