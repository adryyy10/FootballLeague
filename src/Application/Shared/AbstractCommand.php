<?php

namespace App\Application\Shared;

abstract class AbstractCommand
{

    /**
     * @param array $data
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->assertMandatoryAttributes();
    }

    abstract public function assertMandatoryAttributes();
}
