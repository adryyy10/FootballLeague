<?php

namespace App\Application\Position\GetPositions;

class Response
{

    public array $functions;

    public function __construct(array $positions) {
        $this->positions = $positions;
    }

    /**
     * Get the value of positions
     */ 
    public function getPositions(): array
    {
        return $this->positions;
    }
}
