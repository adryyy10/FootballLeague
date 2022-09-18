<?php

namespace App\Application\Coach\DeleteCoach;

use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;

class CommandHandler
{

    /**
     * @var CoachRepositoryInterface $coachRepository
     */
    public $coachRepository;

    public function __construct(
        CoachRepositoryInterface $coachRepository
    ) {
        $this->coachRepository  = $coachRepository;
    }

    public function __invoke(Command $command): Response
    {
        // Validate our business logic before adding a new coach, just in case
        $this->validateBusinessLogic($command);

        $coach = $this->coachRepository->find($command->getCoachId());

        // In case we didn't find the coach, we do not delete it and return isDeleted = false in Response
        if (empty($coach)) {
            return new Response(false);
        }

        //remove coach
        $this->coachRepository->remove($coach, true);

        return new Response(true);
    }

    public function validateBusinessLogic(Command $command) 
    {
        if (empty($command->getCoachId())) {
            throw new \Exception('Coach id is empty!');
        }
    }

}
