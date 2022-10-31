<?php

namespace App\Application\Position\GetPositions;

use App\Domain\Position\PositionRepositoryInterface;

class QueryHandler
{

    public PositionRepositoryInterface $positionRepository;

    public function __construct(PositionRepositoryInterface $positionRepository) {
        $this->positionRepository = $positionRepository;
    }

    public function __invoke()
    {
        $positions = $this->positionRepository->findAll();

        return new Response($positions);
    }

}
