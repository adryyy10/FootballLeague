<?php

namespace App\Domain\Club;

interface ClubRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    public function findOneBy(array $criteria, array $orderBy = null);

    public function findAll();

    public function findByNoCoach(): array;

    public function findOneByCoachId(int $coachId): ?Club;

    public function add(Club $entity, bool $flush = false);

    public function remove(Club $entity, bool $flush = false): void;

    public function flush();
}
