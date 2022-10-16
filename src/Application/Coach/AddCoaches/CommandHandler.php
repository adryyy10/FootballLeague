<?php

namespace App\Application\Coach\AddCoaches;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;
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
        // If getCoachId() is null --> insert new coach, else --> update coach 
        if (empty($command->getCoachId())) {
            // New Coach entity created to be able to insert it as a new coach
            $coach = Coach::create(
                $command->getCoachName(),
                $command->getSalary()
            );

            $this->coachRepository->add($coach, true);
        } else {
            // We find the coach and update new fields
            $coach = $this->coachRepository->find($command->getCoachId());

            if (empty($coach)) {
                throw new EntityNotFoundException($command->getCoachId(), Coach::class);
            }

            // Update the entity from domain layer
            Coach::update(
                $coach, 
                $command->getCoachName(),
                $command->getSalary()
            );

            $this->coachRepository->flush();

            // Find if coach has a club
            $coachClub = $this->clubRepository->findOneByCoachId($command->getCoachId());

            // Remove coach from previous club
            if (!empty($coachClub)) {
                $coachClub->setCoach(null);
                $this->clubRepository->flush();
            }

            // Add coach to the new club
            if (!empty($club)) {
                $club->setCoach($coach);
                $this->clubRepository->flush();
            }
        }
    }
}
