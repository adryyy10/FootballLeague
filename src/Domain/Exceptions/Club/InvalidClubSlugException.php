<?php

namespace App\Domain\Exceptions\Club;

use DomainException;

final class InvalidClubSlugException extends DomainException
{
    public function __construct() {
        parent::__construct('Invalid Club Slug');
    }
}
