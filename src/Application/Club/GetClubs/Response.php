<?php

namespace App\Application\Club\GetClubs;

class Response
{

    /**
     * @var array $clubs
     */
    private $clubs;

    public function __construct(array $clubs)
    {
        $this->clubs = $clubs;
    }

     /**
      * Get the value of clubs
      */ 
     public function getClubs(): array
     {
          return $this->clubs;
     }
}
