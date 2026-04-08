<?php
namespace App\Application\Exception;

use Exception;

class DuplicateResourceException extends Exception
{
    public function __construct(string $message = "Duplicate resource", int $code = 409, public ?string $field = null)
    {
        parent::__construct($message, $code);
    }
}
