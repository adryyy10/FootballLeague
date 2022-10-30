<?php

namespace App\Domain\Exceptions;

class EmptyPlayerIdException extends DomainException
{

    protected function domainException(string $message): string
    {
        return $message;
    }

}
