<?php

declare(strict_types=1);

namespace App\Application\Exception;

use Exception;

class DatabaseException extends Exception
{
    public function __construct(string $message = "Database error", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
