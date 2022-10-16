<?php

namespace App\Application\Club\GetClub;

use App\Domain\Club\ClubRepositoryInterface;

class QueryHandler {

    /**
     * @var ClubRepositoryInterface $clubRepository
     */
    protected $clubRepository;

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function __invoke(Query $query): Response
    {
        $club = $this->clubRepository->find($query->getClubId());

        return new Response(
            $club
        );
    }


}