<?php

namespace App\Domain\Player;

interface PlayerRepositoryInterface
{
    public function add(Player $entity, bool $flush = false);

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findAll();

    public function remove(Player $entity, bool $flush = false);
}
