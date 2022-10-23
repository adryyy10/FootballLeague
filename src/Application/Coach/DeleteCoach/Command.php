<?php

namespace App\Application\Coach\DeleteCoach;

use App\Application\Shared\AbstractCommand;
use stdClass;
use Webmozart\Assert\Assert;

class Command extends AbstractCommand
{

    /**
     * @var stdClass $data
     */
    protected $data;

    public function __construct(stdClass $data) 
    {
        parent::__construct($data);
        $this->data = $data;
    }

    public function getCoachId(): int
    {
        return $this->data->coachId;
    }
    
    /**
     * This method checks the type of the variables and if they are mandatory or not
     */
    public function assertMandatoryAttributes()
    {
        Assert::propertyExists($this->data, 'coachId');
        Assert::integer($this->data->coachId);
    }

}
