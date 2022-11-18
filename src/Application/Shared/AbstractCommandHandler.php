<?php

namespace App\Application\Shared;

abstract class AbstractCommandHandler
{

    /**
     * @param $data
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->validateBusinessLogic($data);
    }

    abstract protected function validateBusinessLogic($data);

}
