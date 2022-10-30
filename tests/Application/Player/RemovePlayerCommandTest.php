<?php

namespace App\Tests\Application\Player;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Player\RemovePlayer;
use InvalidArgumentException;

class RemovePlayerCommandTest extends TestCase
{

    protected stdClass $data;

    protected function setUp(): void
    {
        $this->data = (object)[
            'playerId' => 1
        ];
    }

    public function testHappyPath()
    {
        $command = new RemovePlayer\Command($this->data);

        $this->assertEquals($command->getPlayerId(), $this->data->playerId);
        $this->assertIsInt($command->getPlayerId());
    }

    public function testInvalidPlayerId()
    {
        $this->data->playerId = null;

        $this->expectException(InvalidArgumentException::class);

        new RemovePlayer\Command($this->data);
    }

}
