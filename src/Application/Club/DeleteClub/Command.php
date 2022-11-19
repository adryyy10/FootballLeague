<?php

namespace App\Application\Club\DeleteClub;

use App\Application\Shared\AbstractCommand;
use Webmozart\Assert\Assert;
use stdClass;

class Command extends AbstractCommand
{

    /**
     * @var stdClass $data
     */
    public $data;

    public function __construct(stdClass $data)
    {
        parent::__construct($data);
        $this->data = $data;
    }

    public function getClubId(): int
    {
        return $this->data->clubId;
    }

    protected function assertMandatoryAttributes()
    {
        Assert::propertyExists($this->data, 'clubId');
        Assert::integer($this->data->clubId);
    }
}
