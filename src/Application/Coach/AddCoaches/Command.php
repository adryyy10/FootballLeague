<?php

namespace App\Application\Coach\AddCoaches;

use App\Application\Shared\AbstractCommand;
use App\Domain\Club\Club;
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

    public function getCoachName(): string
    {
        return $this->data['coachName'];
    }

    public function getSalary(): float
    {
        return $this->data['salary'];
    }

    public function getClubId(): ?string
    {
        return $this->data['clubId'];
    }
    
    public function assertMandatoryAttributes()
    {
        // In this method we will check the typing of the variables and if the need to be mandatory or not
        Assert::propertyExists($this->data['coachName'], 'coachName');
        Assert::string($this->data['coachName']);

        Assert::propertyExists($this->data['salary'], 'salary');
        Assert::float($this->data['salary']);

        if (isset($this->data['clubId'])) {
            Assert::string($this->data['clubId']);
        }
    }

}
