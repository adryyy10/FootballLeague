<?php

namespace App\Domain\Exceptions;

use Exception;

abstract class DomainException extends Exception
{

    public function __construct(string $message) {
        printf($message);
    }
}
