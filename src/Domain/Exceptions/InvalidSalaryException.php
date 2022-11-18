<?php

namespace App\Domain\Exceptions;

use DomainException;

class InvalidSalaryException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Salary');
    }
}
