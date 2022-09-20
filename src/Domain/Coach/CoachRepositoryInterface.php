<?php

namespace App\Domain\Coach;

interface CoachRepositoryInterface
{
    public function find(int $id, $lockMode = null, $lockVersion = null);

    public function findAll();

    public function add(Coach $entity, bool $flush = false);

    public function flush();

    public function remove(Coach $entity, bool $flush = false): void;
}
