<?php

namespace App\Application\Club\AddClub;

use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Stadium\Stadium;
use App\Domain\Stadium\StadiumRepositoryInterface;

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

    /**
     * @var StadiumRepositoryInterface $stadiumRepository
     */
    public $stadiumRepository;

    public function __construct(
        CoachRepositoryInterface $coachRepository,
        ClubRepositoryInterface $clubRepository,
        StadiumRepositoryInterface $stadiumRepository
    ) {
        $this->coachRepository      = $coachRepository;
        $this->clubRepository       = $clubRepository;
        $this->stadiumRepository    = $stadiumRepository;
    }

    public function __invoke(Command $command): void
    {

        /** Find coach */
        $coach = $this->coachRepository->find($command->getCoachId());

        if (empty($coach)) {
            throw new EntityNotFoundException($command->getCoachId(), Coach::class);
        }

        /** Find stadium */
        $stadium = $this->stadiumRepository->find($command->getStadiumId());

        if (empty($stadium)) {
            throw new EntityNotFoundException($command->getStadiumId(), Stadium::class);
        }  
        
        /** If getClubId() is null --> insert new club, else --> update club */
        if (empty($command->getClubId())) {

            /** New Club entity created */
            $club = Club::create(
                $command->getClubName(),
                $command->getBudget(),
                $coach,
                $stadium,
                $command->getPalette(),
                $command->getSlug()
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
                $coach,
                $stadium,
                $command->getSlug(),
                $club->getPalette()
            );

            $this->clubRepository->flush();
        }
    }
}
