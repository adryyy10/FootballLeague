<?php

namespace App\Application\Player\RemovePlayer;

use App\Application\Shared\AbstractCommand;
use stdClass;
use Webmozart\Assert\Assert;

class Command extends AbstractCommand
{

    protected $data;

    public function __construct(stdClass $data) {
        parent::__construct($data);
        $this->data = $data;
    }

    public function getPlayerId(): int
    {
        return $this->data->playerId;
    }

    protected function assertMandatoryAttributes()
    {
        Assert::propertyExists($this->data, 'playerId');
        Assert::integer($this->data->playerId);
    }

}
