<?php

namespace App\Application\Coach\AddCoaches;

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
        $this->data = $data;
    }

    public function getCoachId(): ?int
    {
        return $this->data->coachId;
    }

    public function getCoachName(): string
    {
        return $this->data->coachName;
    }

    public function getSalary(): float
    {
        return $this->data->salary;
    }
    
    /**
     * This method checks the type of the variables and if they are mandatory or not
     */
    public function assertMandatoryAttributes()
    {
        if (isset($this->data->coachId)) {
            Assert::integer($this->data->coachId);
        }

        Assert::propertyExists($this->data, 'coachName');
        Assert::string($this->data->coachName);

        Assert::propertyExists($this->data, 'salary');
        Assert::float($this->data->salary);
    }

}
