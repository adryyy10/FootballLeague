<?php

namespace App\Application\Coach\GetCoach;

use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;

class QueryHandler {

    /**
     * @var CoachRepositoryInterface $coachRepository
     */
    protected $coachRepository;

    public function __construct(CoachRepositoryInterface $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function __invoke(Query $query): Response
    {
        /** Validate the business logic from the Entity */
        Coach::validateBusinessModel($query->getCoachId());

        $coach = $this->coachRepository->find($query->getCoachId());

        return new Response(
            $coach
        );
    }


}