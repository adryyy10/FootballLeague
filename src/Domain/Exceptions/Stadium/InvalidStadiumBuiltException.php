<?php

namespace App\Domain\Exceptions\Stadium;

use DomainException;

final class InvalidStadiumBuiltException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Stadium built');
    }
}
