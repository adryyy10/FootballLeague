<?php

namespace App\Domain\Exceptions;

class EntityNotFoundException extends DomainException
{

    public function domainException(string $message): string
    {
        return $message;
    }

}
