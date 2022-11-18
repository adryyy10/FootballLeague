<?php

namespace App\Application\Player\AddPlayer;

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

    public function getName(): string
    {
        return $this->data->playerName;
    }

    public function getPosition(): string
    {
        return $this->data->position;
    }

    public function getSalary(): float
    {
        return $this->data->salary;
    }

    public function getClubId(): ?int
    {
        return $this->data->clubId;
    }

    protected function assertMandatoryAttributes()
    {
        Assert::propertyExists($this->data, 'playerName');
        Assert::string($this->data->playerName);

        Assert::propertyExists($this->data, 'position');
        Assert::string($this->data->position);

        Assert::propertyExists($this->data, 'salary');
        Assert::float($this->data->salary);

        if (!empty($this->data->clubId)) {
            Assert::integer($this->data->clubId);
        }
    }

}
