<?php

namespace App\Domain\Player;

interface PlayerRepositoryInterface
{
    public function add(Player $entity, bool $flush = false);

    public function findAll();
}
