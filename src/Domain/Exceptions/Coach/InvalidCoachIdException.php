<?php

namespace App\Domain\Exceptions\Coach;

use DomainException;

final class InvalidCoachIdException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Coach Id');
    }
}
