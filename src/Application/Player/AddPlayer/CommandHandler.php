<?php

namespace App\Application\Player\AddPlayer;

use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;

class CommandHandler
{

    private PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository) 
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(Command $command): void
    {
        $player = Player::create(
            $command->getName(),
            $command->getPosition(),
            $command->getSalary()
        );

        $this->playerRepository->add($player, true);
    }

}
