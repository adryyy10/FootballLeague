<?php

namespace App\Application\Club\AddClubs;

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

    public function getClubId(): ?int
    {
        return $this->data['clubId'];
    }

    public function getClubName(): string
    {
        return $this->data['clubName'];
    }

    public function getBudget(): float
    {
        return $this->data['budget'];
    }

    public function getCoachId(): int
    {
        return $this->data['coachId'];
    }
    
    public function assertMandatoryAttributes()
    {
        // In this method we will check the typing of the variables and if the need to be mandatory or not
        if (isset($this->data['clubId']) && $this->data['clubId'] > 0) {
            Assert::integer($this->data['clubId']);
        }

        Assert::propertyExists($this->data['clubName'], 'clubName');
        Assert::string($this->data['clubName']);

        Assert::propertyExists($this->data['budget'], 'budget');
        Assert::float($this->data['budget']);

        Assert::propertyExists($this->data['coachId'], 'coachId');
        Assert::integer($this->data['coachId']);
    }

}
