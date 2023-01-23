<?php

namespace App\Domain\Exceptions\Stadium;

use DomainException;

final class InvalidStadiumCapacityException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Stadium capacity');
    }
}
