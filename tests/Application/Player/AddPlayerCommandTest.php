<?php

namespace App\Tests\Application\Player;

use App\Application\Player\AddPlayer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class AddPlayerCommandTest extends TestCase
{
    public stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object)[
            'playerId'      => 1,
            'playerName'    => 'test',
            'salary'        => 100.1,
            'position'      => 'test',
            'clubId'        => 1
        ];
    }

    public function testGetValidQuery()
    {
        $command = new AddPlayer\Command($this->data);

        $this->assertIsString($command->getName());
        $this->assertIsString($command->getPosition());
        $this->assertIsFloat($command->getSalary());
    }

    public function testInvalidPlayerName()
    {
        $this->data->playerName = 1;

        $this->expectException(InvalidArgumentException::class);
        new AddPlayer\Command($this->data);
    }

    public function testInvalidSalary()
    {
        $this->data->salary = 'test';

        $this->expectException(InvalidArgumentException::class);
        new AddPlayer\Command($this->data);
    }

    public function testInvalidPlayerId()
    {
        $this->data->playerId = 'test';

        $this->expectException(InvalidArgumentException::class);
        new AddPlayer\Command($this->data);
    }

    public function testInvalidClubId()
    {
        $this->data->clubId = 'test';

        $this->expectException(InvalidArgumentException::class);
        new AddPlayer\Command($this->data);
    }

}
