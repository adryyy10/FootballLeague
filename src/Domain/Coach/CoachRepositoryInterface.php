<?php

namespace App\Domain\Coach;

interface CoachRepositoryInterface
{
    public function findAll();

    public function add(Coach $entity, bool $flush = false);
}
