<?php

namespace App\Domain\Exceptions\Stadium;

use DomainException;

final class InvalidStadiumNameException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Stadium name');
    }
}
