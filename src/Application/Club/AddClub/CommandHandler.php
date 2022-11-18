<?php

namespace App\Application\Club\AddClub;

use App\Domain\Club\Club;
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

    public function __invoke(Command $command): void
    {

        // We need to find the coach that we have selected for the new club
        $coach = $this->coachRepository->find($command->getCoachId());

        if (empty($coach)) {
            throw new EntityNotFoundException($command->getCoachId(), Coach::class);
        }

        // If getClubId() is null --> insert new club, else --> update club 
        if (empty($command->getClubId())) {

            // New Club entity created to be able to insert it as a new coach
            $club = Club::create(
                $command->getClubName(),
                $command->getBudget(),
                $coach
            );

            $this->clubRepository->add($club, true);
        } else {
            // We find the coach and update new fields
            $club = $this->clubRepository->find($command->getClubId());

            if (empty($club)) {
                throw new EntityNotFoundException($command->getClubId(), Club::class);
            }

            // Update the entity from domain layer
            Club::update(
                $club, 
                $command->getClubName(),
                $command->getBudget(),
                $coach
            );

            $this->clubRepository->flush();
        }
    }
}
