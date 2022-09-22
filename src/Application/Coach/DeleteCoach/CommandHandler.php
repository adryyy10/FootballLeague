<?php

namespace App\Application\Coach\DeleteCoach;

use App\Domain\Coach\CoachRepositoryInterface;
use App\Domain\Club\ClubRepositoryInterface;
use App\Infrastructure\Doctrine\Model\Club\ClubRepository;

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

    public function __invoke(Command $command): Response
    {
        // Validate our business logic before adding a new coach, just in case
        $this->validateBusinessLogic($command);

        $coach = $this->coachRepository->find($command->getCoachId());

        // In case we didn't find the coach, we do not delete it and return isDeleted = false in Response
        if (empty($coach)) {
            return new Response(false);
        }

        // Find the club with the coach associated and set coach_id to null
        $coachClub = $this->clubRepository->findOneByCoachId($command->getCoachId());

        if (!empty($coachClub)) {
            $coachClub->setCoach(null);
            $this->clubRepository->flush();
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
