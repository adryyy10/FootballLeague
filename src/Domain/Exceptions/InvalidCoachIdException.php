<?php

namespace App\Domain\Exceptions;

final class InvalidCoachIdException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Coach Id');
    }
}
