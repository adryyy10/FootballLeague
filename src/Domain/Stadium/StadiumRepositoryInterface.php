<?php

namespace App\Domain\Stadium;

interface StadiumRepositoryInterface
{

    public function find($id, $lockMode = null, $lockVersion = null);

    public function findAll();
}
