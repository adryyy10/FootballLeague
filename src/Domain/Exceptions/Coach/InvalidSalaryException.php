<?php

namespace App\Domain\Exceptions\Coach;

use DomainException;

class InvalidSalaryException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Salary');
    }
}
