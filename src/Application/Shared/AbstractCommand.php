<?php

namespace App\Application\Shared;

use stdClass;

abstract class AbstractCommand
{

    /**
     * @param stdClass $data
     */
    protected $data;

    public function __construct(stdClass $data)
    {
        $this->data = $data;
        $this->assertMandatoryAttributes();
    }

    abstract protected function assertMandatoryAttributes();
}
