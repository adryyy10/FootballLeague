<?php

namespace App\Application\Coach\GetCoachesWithNoClub;

class Response
{
    /**
     * @var array $coaches
     */
    protected $coaches;

    public function __construct(array $coaches)
    {
        $this->coaches = $coaches;
    }

     /**
      * Get the value of coaches
      */ 
     public function getCoaches()
     {
          return $this->coaches;
     }
}
