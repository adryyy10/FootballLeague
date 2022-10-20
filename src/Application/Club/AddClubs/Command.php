<?php

namespace App\Application\Club\AddClubs;

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

    public function getClubId(): ?int
    {
        return $this->data->clubId;
    }

    public function getClubName(): string
    {
        return $this->data->clubName;
    }

    public function getBudget(): float
    {
        return $this->data->budget;
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
        if (isset($this->data->clubId) && $this->data->clubId > 0) {
            Assert::integer($this->data->clubId);
        }

        Assert::propertyExists($this->data, 'clubName');
        Assert::string($this->data->clubName);

        Assert::propertyExists($this->data, 'budget');
        Assert::float($this->data->budget);

        Assert::propertyExists($this->data, 'coachId');
        Assert::integer($this->data->coachId);
    }

}
