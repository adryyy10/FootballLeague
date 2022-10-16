<?php

namespace App\Domain\Exceptions;

use Exception;

abstract class DomainException extends Exception
{

    protected function domainException(string $message): string
    {
        return $message;
    }

}
