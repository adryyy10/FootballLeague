<?php

namespace App\Application\Club\GetClub;

use App\Application\Shared\AbstractCommand;
use stdClass;
use Webmozart\Assert\Assert;

class Query extends AbstractCommand
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
        // In this method we will check the typing of the variables and if the need to be mandatory or not
        Assert::propertyExists($this->data, 'clubId');
        Assert::integer($this->data->clubId);
    }

}
