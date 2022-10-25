<?php

namespace App\Application\Player\GetPlayers;

use App\Domain\Player\PlayerRepositoryInterface;

class QueryHandler
{

    private PlayerRepositoryInterface $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke()
    {
        $players = $this->playerRepository->findAll();

        return new Response($players);
    }

}
