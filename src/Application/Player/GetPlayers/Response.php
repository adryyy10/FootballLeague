<?php

namespace App\Application\Player\GetPlayers;

class Response
{

    protected $players;

    public function __construct(array $players)
    {
        $this->players = $players;
    }

    /**
     * Get the value of players
     */ 
    public function getPlayers(): array
    {
        return $this->players;
    }
}
