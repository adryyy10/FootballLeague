<?php

namespace App\Application\Coach\AddCoach;

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
        /** If getCoachId() is null --> insert new coach, else --> update coach  */
        if (empty($command->getCoachId())) {
            /** New entity Coach created */
            $coach = Coach::create(
                $command->getCoachName(),
                $command->getSalary()
            );

            $this->coachRepository->add($coach, true);
        } else {
            /** Find coach */
            $coach = $this->coachRepository->find($command->getCoachId());

            if (empty($coach)) {
                throw new EntityNotFoundException($command->getCoachId(), Coach::class);
            }

            /** Update Coach */
            Coach::update(
                $coach, 
                $command->getCoachName(),
                $command->getSalary()
            );

            $this->coachRepository->flush();
        }
    }
}
