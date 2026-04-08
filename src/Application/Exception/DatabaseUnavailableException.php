<?php
namespace App\Application\Exception;

use Exception;

class DatabaseUnavailableException extends Exception
{
    public function __construct(string $message = "Database unavailable", int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
