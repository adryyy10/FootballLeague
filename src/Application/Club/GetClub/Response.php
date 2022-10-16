<?php

namespace App\Application\Club\GetClub;

use App\Domain\Club\Club;

class Response
{
    /**
     * @var Club $club
     */
    protected $club;

    public function __construct(Club $club)
    {
        $this->club = $club;
    }

     /**
      * Get the value of entity club
      */ 
     public function getClub(): Club
     {
          return $this->club;
     }
}
