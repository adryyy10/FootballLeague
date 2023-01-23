<?php

namespace App\Application\Stadium\AddStadium;

use App\Domain\Stadium\Stadium;
use App\Domain\Stadium\StadiumRepositoryInterface;

class CommandHandler
{

    private StadiumRepositoryInterface $stadiumRepository;

    public function __construct(StadiumRepositoryInterface $stadiumRepository) 
    {
        $this->stadiumRepository = $stadiumRepository;
    }

    public function __invoke(Command $command): void
    {

        $stadium = $this->stadiumRepository->find($command->getId());

        // If we find $stadium, we are updating an existing one
        if (!empty($stadium)) {

            /*Stadium::update(
                $player,
                $command->getName(),
                $command->getPosition(),
                $command->getSalary(),
                $club
            );

            $this->stadiumRepository->flush();*/
        } else {
            $stadium = Stadium::create(
                $command->getName(),
                $command->getCapacity(),
                $command->getBuilt(),
                $command->getAddress()
            );

            $this->stadiumRepository->add($stadium, true);
        }
    }

}
