<?php

namespace App\Application\Coach\DeleteCoach;

use App\Application\Shared\AbstractCommand;
use Webmozart\Assert\Assert;

class Command extends AbstractCommand
{

    /**
     * @var array $data
     */
    protected $data;

    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    public function getCoachId(): int
    {
        return $this->data['coachId'];
    }
    
    public function assertMandatoryAttributes()
    {
        // In this method we will check the typing of the variables and if the need to be mandatory or not
        Assert::propertyExists($this->data['coachId'], 'coachId');
        Assert::integer($this->data['coachId']);
    }

}
