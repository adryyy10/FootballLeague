<?php

namespace App\Application\Coach\DeleteCoach;

class Response
{
    /**
     * @var bool $isDeletedCoach
     */
    protected $isDeletedCoach;

    public function __construct(bool $isDeletedCoach)
    {
        $this->isDeletedCoach = $isDeletedCoach;
    }

     /**
      * Get the value of coaches
      */ 
     public function isDeletedCoach()
     {
          return $this->isDeletedCoach;
     }
}
