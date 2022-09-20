<?php

namespace App\Application\Coach\AddCoaches;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;

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

        // Get the club via clubId
        $club = null;
        if (!empty($command->getClubId())) {
            $club = $this->clubRepository->find((int)$command->getClubId());
        }

        // If getCoachId() is null --> insert new coach, else --> update coach 
        if (empty($command->getCoachId())) {
            // New Coach entity created to be able to insert it as a new coach
            $coach = new Coach (
                $command->getCoachName(),
                $command->getSalary(),
                $club
            );

            $this->coachRepository->add($coach, true);
        } else {
            // We find the coach and update new fields
            $coach = $this->coachRepository->find($command->getCoachId());
            $coach->setName($command->getCoachName());
            $coach->setSalary($command->getSalary());
            $coach->setClub($club);

            $this->coachRepository->flush();
        }
    }

    public function validateBusinessLogic(Command $command) 
    {
        if (empty($command->getCoachName())) {
            throw new \Exception('Coach name is empty!');
        }

        if (empty($command->getSalary())) {
            throw new \Exception('Salary is empty!');
        }
    }

}
