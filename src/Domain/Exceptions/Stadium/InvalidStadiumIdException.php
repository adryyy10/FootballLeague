<?php

namespace App\Domain\Exceptions\Stadium;

use DomainException;

final class InvalidStadiumIdException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Stadium id');
    }
}
