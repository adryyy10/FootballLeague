<?php

namespace App\Domain\Exceptions;

use DomainException;

final class EmptySalaryException extends DomainException
{

    public function domainException(string $message): string
    {
        return $message;
    }

}
