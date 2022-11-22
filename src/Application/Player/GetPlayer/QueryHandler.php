<?php

namespace App\Application\Player\GetPlayer;

use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;

class QueryHandler {

    /**
     * @var PlayerRepositoryInterface $playerRepository
     */
    protected $playerRepository;

    public function __construct(PlayerRepositoryInterface $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function __invoke(Query $query): Response
    {
        /** Validate the business logic from the Entity */
        Player::validateBusinessModel($query->getId());

        $player = $this->playerRepository->find($query->getId());

        return new Response(
            $player
        );
    }


}