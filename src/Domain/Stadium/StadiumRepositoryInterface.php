<?php

namespace App\Domain\Stadium;

interface StadiumRepositoryInterface
{
    public function add(Stadium $entity, bool $flush = false);

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findAll();
}
