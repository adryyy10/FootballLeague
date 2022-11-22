<?php

namespace App\Application\Player\AddPlayer;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Exceptions\EntityNotFoundException;
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

        if (!empty($command->getId())) {
            $player = $this->playerRepository->find($command->getId());

            if (empty($player)) {
                throw new EntityNotFoundException($command->getId(), Player::class);
            }

            Player::update(
                $player,
                $command->getName(),
                $command->getPosition(),
                $command->getSalary(),
                $club
            );

            $this->playerRepository->flush();
        } else {
            $player = Player::create(
                $command->getName(),
                $command->getPosition(),
                $command->getSalary(),
                $club
            );

            $this->playerRepository->add($player, true);
        }
    }

}
