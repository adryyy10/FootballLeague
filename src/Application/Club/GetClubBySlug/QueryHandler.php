<?php

namespace App\Application\Club\GetClubBySlug;

use App\Domain\Club\Club;
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

        /** Validate the business logic from the Entity */
        Club::validateBusinessModel(null, $query->getSlug());

        $club = $this->clubRepository->findOneBy(['slug' => $query->getSlug()]);

        return new Response(
            $club
        );
    }


}