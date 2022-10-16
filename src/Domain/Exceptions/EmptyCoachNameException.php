<?php

namespace App\Domain\Exceptions;

use DomainException;

final class EmptyCoachNameException extends DomainException
{

    public function domainException(string $message): string
    {
        return $message;
    }

}
