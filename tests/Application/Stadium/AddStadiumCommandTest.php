<?php

namespace App\Tests\Application\Player;

use App\Application\Stadium\AddStadium;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class AddStadiumCommandTest extends TestCase
{
    public stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object)[
            'stadiumName'   => 'test',
            'capacity'      => 100,
            'built'         => 1947,
            'address'       => 'test'
        ];
    }

    public function testGetValidQuery()
    {
        $command = new AddStadium\Command($this->data);

        $this->assertIsString($command->getName());
        $this->assertIsInt($command->getCapacity());
        $this->assertIsInt($command->getBuilt());
        $this->assertIsString($command->getAddress());
    }

    public function testInvalidStadiumName()
    {
        $this->data->stadiumName = 1;

        $this->expectException(InvalidArgumentException::class);
        new AddStadium\Command($this->data);
    }

    public function testInvalidCapacity()
    {
        $this->data->capacity = 'test';

        $this->expectException(InvalidArgumentException::class);
        new AddStadium\Command($this->data);
    }

    public function testInvalidBuilt()
    {
        $this->data->built = 'test';

        $this->expectException(InvalidArgumentException::class);
        new AddStadium\Command($this->data);
    }

    public function testInvalidStadiumAddress()
    {
        $this->data->address = 1;

        $this->expectException(InvalidArgumentException::class);
        new AddStadium\Command($this->data);
    }

}
