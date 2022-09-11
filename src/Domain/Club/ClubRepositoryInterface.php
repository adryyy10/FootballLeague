<?php

namespace App\Domain\Club;

interface ClubRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
}
