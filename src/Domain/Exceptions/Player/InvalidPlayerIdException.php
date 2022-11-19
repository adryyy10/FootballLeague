<?php

namespace App\Domain\Exceptions;

final class InvalidPlayerIdException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Player id');
    }
}
