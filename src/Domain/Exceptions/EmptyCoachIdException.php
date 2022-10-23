<?php

namespace App\Domain\Exceptions;

class EmptyCoachIdException extends DomainException
{

    protected function domainException(string $message): string
    {
        return $message;
    }

}
