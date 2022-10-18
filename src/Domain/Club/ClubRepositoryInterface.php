<?php

namespace App\Domain\Club;

interface ClubRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    public function findAll();

    public function findByNoCoach();

    public function findOneByCoachId(int $coachId);

    public function add(Club $entity, bool $flush = false);

    public function flush();
}
