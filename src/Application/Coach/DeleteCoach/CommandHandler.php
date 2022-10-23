<?php

namespace App\Application\Coach\DeleteCoach;

use App\Domain\Coach\CoachRepositoryInterface;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Exceptions\EmptyCoachIdException;
use App\Domain\Exceptions\EntityNotFoundException;

class CommandHandler
{

    /**
     * @var CoachRepositoryInterface $coachRepository
     */
    public $coachRepository;

    /**
     * @var ClubRepositoryInterface $clubRepository
     */
    public $clubRepository;

    public function __construct(
        CoachRepositoryInterface $coachRepository,
        ClubRepositoryInterface $clubRepository
    ) {
        $this->coachRepository  = $coachRepository;
        $this->clubRepository   = $clubRepository;
    }

    public function __invoke(Command $command)
    {
        // Validate our business logic before adding a new coach, just in case
        $this->validateBusinessLogic($command);

        $coach = $this->coachRepository->find($command->getCoachId());

        // In case we didn't find the coach, we do not delete it and return isDeleted = false in Response
        if (empty($coach)) {
            throw new EntityNotFoundException($command->getCoachId(), Coach::class);
        }

        // Find the club with the coach associated and set coach_id to null
        $coachClub = $this->clubRepository->findOneByCoachId($command->getCoachId());

        if (!empty($coachClub)) {
            $coachClub::setCoachToNull($coachClub);
            $this->clubRepository->flush();
        }

        //remove coach
        $this->coachRepository->remove($coach, true);
    }

    public function validateBusinessLogic(Command $command) 
    {
        if ($command->getCoachId() <= 0) {
            throw new EmptyCoachIdException('Invalid coach id!');
        }
    }
}
