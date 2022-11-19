<?php

namespace App\Domain\Exceptions\Player;

use DomainException;

final class InvalidPlayerIdException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Player id');
    }
}
