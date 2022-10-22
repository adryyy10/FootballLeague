<?php

namespace App\Application\Club\DeleteClub;

use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Exceptions\EntityNotFoundException;

class CommandHandler
{

    public ClubRepositoryInterface $clubRepository;

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function __invoke(Command $command) 
    {
        $club = $this->clubRepository->find($command->getClubId());

        if(empty($club)) {
            throw new EntityNotFoundException($command->getClubId(), Club::class);
        }

        $this->clubRepository->remove($club, true);
    }

}
