<?php

namespace App\Application\Coach\GetCoachesWithNoClub;

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

    public function __invoke(): Response
    {
        $coaches = $this->coachRepository->findByNoClub();

        return new Response(
            $coaches
        );
    }


}