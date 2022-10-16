<?php

namespace App\Domain\Exceptions;

class EntityNotFoundException extends \Exception
{

    public function __construct(?string $uid, string $entity)
    {
        parent::__construct(sprintf('The $s entity (UID %s) does not exist', $entity, $uid));
    }

}
