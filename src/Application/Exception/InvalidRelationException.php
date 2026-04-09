<?php

declare(strict_types=1);

namespace App\Application\Exception;

use Exception;

class InvalidRelationException extends Exception
{
    public function __construct(string $message = "Invalid relation", int $code = 409)
    {
        parent::__construct($message, $code);
    }
}
