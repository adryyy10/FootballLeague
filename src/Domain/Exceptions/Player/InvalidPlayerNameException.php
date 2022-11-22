<?php

namespace App\Domain\Exceptions\Player;

use DomainException;

final class InvalidPlayerNameException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Player name');
    }
}
