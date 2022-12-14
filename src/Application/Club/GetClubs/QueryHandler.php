<?php

namespace App\Application\Club\GetClubs;

use App\Domain\Club\ClubRepositoryInterface;

class QueryHandler
{

    /**
     * @var ClubRepositoryInterface $clubRepository 
     */
    public $clubRepository;

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function __invoke(): Response
    {
        $clubs = $this->clubRepository->findAll();

        return new Response(
            $clubs
        );
    }
}
