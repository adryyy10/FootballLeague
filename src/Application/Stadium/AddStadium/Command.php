<?php

namespace App\Application\Stadium\AddStadium;

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

    public function getId(): ?int
    {
        return $this->data->stadiumId;
    }

    public function getName(): string
    {
        return $this->data->stadiumName;
    }

    public function getCapacity(): int
    {
        return $this->data->capacity;
    }

    public function getBuilt(): int
    {
        return $this->data->built;
    }

    public function getAddress(): string
    {
        return $this->data->address;
    }

    protected function assertMandatoryAttributes()
    {
        if (!empty($this->data->stadiumId)) {
            Assert::integer($this->data->stadiumId);
        }

        Assert::propertyExists($this->data, 'stadiumName');
        Assert::string($this->data->stadiumName);

        Assert::propertyExists($this->data, 'capacity');
        Assert::integer($this->data->capacity);

        Assert::propertyExists($this->data, 'built');
        Assert::integer($this->data->built);

        Assert::propertyExists($this->data, 'address');
        Assert::string($this->data->address);

        if (!empty($this->data->clubId)) {
            Assert::integer($this->data->clubId);
        }
    }

}
