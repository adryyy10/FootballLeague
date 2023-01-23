<?php

namespace App\Application\Stadium\GetStadiums;

use App\Domain\Stadium\StadiumRepositoryInterface;

class QueryHandler
{

    /**
     * @var StadiumRepositoryInterface $stadiumRepository 
     */
    public $stadiumRepository;

    public function __construct(StadiumRepositoryInterface $stadiumRepository)
    {
        $this->stadiumRepository = $stadiumRepository;
    }

    public function __invoke(): Response
    {
        $stadiums = $this->stadiumRepository->findAll();

        return new Response(
            $stadiums
        );
    }
}
