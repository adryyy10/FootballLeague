<?php

namespace App\Tests\Application\Player;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Player\RemovePlayer;
use App\Domain\Exceptions\Player\InvalidPlayerIdException;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;

class RemovePlayerCommandHandlerTest extends TestCase
{

    protected stdClass $data;

    protected array $mocks = [];

    protected function setUp(): void
    {
        $this->data = (object)[
            'playerId' => 1
        ];

        $this->initMocks();
    }

    public function initMocks()
    {
        $this->mocks[PlayerRepositoryInterface::class] = $this->createMock(PlayerRepositoryInterface::class);
        $this->mocks[Player::class] = $this->createMock(Player::class);
    }

    public function initHandler(): RemovePlayer\CommandHandler
    {
        return new RemovePlayer\CommandHandler(
            $this->mocks[PlayerRepositoryInterface::class]
        );
    }

    public function findPlayer(bool $willReturnNull = false)
    {
        if ($willReturnNull) {
            $this->mocks[PlayerRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);
        } else {
            $this->mocks[PlayerRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Player::class]);
        }
    }

    public function testDeletePlayerHappyPath()
    {
        $command = new RemovePlayer\Command($this->data); 

        $handler = $this->initHandler();

        $this->findPlayer();

        $handler($command);
    }

    public function testDeleteInvalidPlayerId()
    {
        $this->data->playerId = -1;

        $command = new RemovePlayer\Command($this->data); 

        $handler = $this->initHandler();

        $this->expectException(InvalidPlayerIdException::class);

        $handler($command);
    }

    public function testPlayerNotFoundException()
    {
        $command = new RemovePlayer\Command($this->data); 

        $handler = $this->initHandler();

        $this->findPlayer(true);

        $this->expectException(EntityNotFoundException::class);

        $handler($command);
    }

}
