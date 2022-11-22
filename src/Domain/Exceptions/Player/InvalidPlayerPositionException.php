<?php

namespace App\Domain\Exceptions\Player;

use DomainException;

final class InvalidPlayerPositionException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Player position');
    }
}
