<?php

namespace App\Application\Player\RemovePlayer;

use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Exceptions\Player\InvalidPlayerIdException;
use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;

class CommandHandler
{

    public PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository) {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(Command $command)
    {
        $this->validateBusinessLogic($command);
        
        $player = $this->playerRepository->find($command->getPlayerId());

        if (empty($player)) {
            throw new EntityNotFoundException($command->getPlayerId(), Player::class);
        }
        
        $this->playerRepository->remove($player, true);
    }

    protected function validateBusinessLogic(Command $command): void
    {
        if ($command->getPlayerId() <= 0) {
            throw new InvalidPlayerIdException('Invalid player id!');
        }
    }
    
}
