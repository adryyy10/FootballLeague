<?php

namespace App\Application\Stadium\GetStadiums;

class Response
{

    /**
     * @var array $stadiums
     */
    private $stadiums;

    public function __construct(array $stadiums)
    {
        $this->stadiums = $stadiums;
    }

     /**
      * Get the value of stadiums
      */ 
     public function getStadiums(): array
     {
          return $this->stadiums;
     }
}
