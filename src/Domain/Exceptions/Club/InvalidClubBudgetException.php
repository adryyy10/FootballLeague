<?php

namespace App\Domain\Exceptions\Club;

use DomainException;

final class InvalidClubBudgetException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Club Budget');
    }
}
