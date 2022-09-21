<?php

namespace App\Application\Club\GetClubsWithNoCoach;

use App\Domain\Club\ClubRepositoryInterface;

class QueryHandler
{

    /**
     * @var ClubRepositoryInterface $clubRepository 
     */

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function __invoke(): Response
    {
        $clubs = $this->clubRepository->findByNoCoach();

        return new Response(
            $clubs
        );
    }
}
