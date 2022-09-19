<?php

namespace App\Application\Coach\GetCoach;

use App\Domain\Coach\Coach;

class Response
{
    /**
     * @var Coach $coach
     */
    protected $coach;

    public function __construct(Coach $coach)
    {
        $this->coach = $coach;
    }

     /**
      * Get the value of entity Coach
      */ 
     public function getCoach(): Coach
     {
          return $this->coach;
     }
}
