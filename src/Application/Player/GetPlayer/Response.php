<?php

namespace App\Application\Player\GetPlayer;

use App\Domain\Player\Player;

class Response
{
    /**
     * @var Player|null $player
     */
    protected $player;

    public function __construct(?Player $player)
    {
        $this->player = $player;
    }

     /**
      * Get the value of entity Player
      */ 
     public function getPlayer(): ?Player
     {
          return $this->player;
     }
}
