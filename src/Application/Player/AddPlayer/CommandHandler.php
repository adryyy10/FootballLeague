<?php

namespace App\Application\Player\AddPlayer;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;

class CommandHandler
{

    private PlayerRepositoryInterface $playerRepository;
    private ClubRepositoryInterface $clubRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository, ClubRepositoryInterface $clubRepository) 
    {
        $this->playerRepository = $playerRepository;
        $this->clubRepository   = $clubRepository;
    }

    public function __invoke(Command $command): void
    {

        $club = $this->clubRepository->find($command->getClubId());

        $player = Player::create(
            $command->getName(),
            $command->getPosition(),
            $command->getSalary(),
            $club
        );

        $this->playerRepository->add($player, true);
    }

}
