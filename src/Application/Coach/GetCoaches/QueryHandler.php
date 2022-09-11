<?php

namespace App\Application\Coach\GetCoaches;

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
        $coaches = $this->coachRepository->findAll();

        return new Response(
            $coaches
        );
    }


}