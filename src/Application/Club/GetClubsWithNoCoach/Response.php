<?php

namespace App\Application\Club\GetClubsWithNoCoach;

class Response
{

    /**
     * @var array $clubs
     */
    public $clubs;

    public function __construct(array $clubs)
    {
        $this->clubs = $clubs;
    }

     /**
      * Get the value of clubs
      */ 
     public function getClubs()
     {
          return $this->clubs;
     }
}
