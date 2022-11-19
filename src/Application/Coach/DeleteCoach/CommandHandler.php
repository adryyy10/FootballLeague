<?php

namespace App\Application\Coach\DeleteCoach;

use App\Domain\Coach\CoachRepositoryInterface;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Exceptions\Coach\InvalidCoachIdException;

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
        /** Validate the business logic from the Entity */
        Coach::validateBusinessModel($command->getCoachId());

        $coach = $this->coachRepository->find($command->getCoachId());

        if (empty($coach)) {
            throw new EntityNotFoundException($command->getCoachId(), Coach::class);
        }

        /** Find the club with the coach associated and set coach_id to null */
        $coachClub = $this->clubRepository->findOneByCoachId($command->getCoachId());

        if (!empty($coachClub)) {
            $coachClub::setCoachToNull($coachClub);
            $this->clubRepository->flush();
        }

        /** remove coach */
        $this->coachRepository->remove($coach, true);
    }

    public function validateBusinessLogic(Command $command) 
    {
        if ($command->getCoachId() <= 0) {
            throw new InvalidCoachIdException();
        }
    }
}
