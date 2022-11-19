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

        /** Find coach */
        $coach = $this->coachRepository->find($command->getCoachId());

        if (empty($coach)) {
            throw new EntityNotFoundException($command->getCoachId(), Coach::class);
        }

        /** If getClubId() is null --> insert new club, else --> update club */
        if (empty($command->getClubId())) {

            /** New Club entity created */
            $club = Club::create(
                $command->getClubName(),
                $command->getBudget(),
                $coach
            );

            $this->clubRepository->add($club, true);
        } else {
            /** Find club */
            $club = $this->clubRepository->find($command->getClubId());

            if (empty($club)) {
                throw new EntityNotFoundException($command->getClubId(), Club::class);
            }

            /** Update entity */
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
