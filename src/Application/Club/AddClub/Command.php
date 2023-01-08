<?php

namespace App\Application\Club\AddClub;

use App\Application\Shared\AbstractCommand;
use stdClass;
use Webmozart\Assert\Assert;

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

    public function getStadiumId(): int
    {
        return $this->data->stadiumId;
    }

    public function getPalette(): string
    {
        return $this->data->palette;
    }

    public function getSlug(): string
    {
        return $this->data->slug;
    }
    
    /**
     * This method checks the type of the variables and if they are mandatory or not
     */
    protected function assertMandatoryAttributes()
    {
        if (isset($this->data->clubId)) {
            Assert::integer($this->data->clubId);
        }

        Assert::propertyExists($this->data, 'clubName');
        Assert::string($this->data->clubName);

        Assert::propertyExists($this->data, 'budget');
        Assert::float($this->data->budget);

        Assert::propertyExists($this->data, 'coachId');
        Assert::integer($this->data->coachId);

        Assert::propertyExists($this->data, 'stadiumId');
        Assert::integer($this->data->stadiumId);

        if (isset($this->data->palette)) {
            Assert::string($this->data->palette);
        }

        Assert::propertyExists($this->data, 'slug');
        Assert::string($this->data->slug);
    }

}
