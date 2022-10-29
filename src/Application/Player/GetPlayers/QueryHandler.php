<?php

namespace App\Application\Player\GetPlayers;

use App\Domain\Player\PlayerRepositoryInterface;

class QueryHandler
{

    /**
     * @var PlayerRepositoryInterface $playerRepository
     */
    protected $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(): Response
    {
        $players = $this->playerRepository->findAll();

        return new Response($players);
    }

}
