<?php

namespace App\Domain\Exceptions;

use DomainException;

final class InvalidCoachNameException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Coach Name');
    }
}
