<?php

namespace App\Tests\Application\Player;

use App\Application\Player\AddPlayer;
use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\Coach\InvalidSalaryException;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Exceptions\Player\InvalidPlayerNameException;
use App\Domain\Exceptions\Player\InvalidPlayerPositionException;
use App\Domain\Player\Player;
use App\Domain\Player\PlayerRepositoryInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class AddPlayerCommandHandlerTest extends TestCase
{

    protected stdClass $data;

    protected array $mocks = [];

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

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[PlayerRepositoryInterface::class]  = $this->createMock(PlayerRepositoryInterface::class);
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[Club::class]                       = $this->createMock(Club::class);
        $this->mocks[Player::class]                     = $this->createMock(Player::class);
        $this->mocks[Coach::class]                      = $this->createMock(Coach::class);
    }

    private function initHandler(): AddPlayer\CommandHandler
    {
        return new AddPlayer\CommandHandler(
            $this->mocks[PlayerRepositoryInterface::class],
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    private function getClub()
    {
        $this->mocks[ClubRepositoryInterface::class]
        ->expects($this->once())
        ->method('find')
        ->willReturn($this->mocks[Club::class]);

        $this->mocks[Club::class]
            ->expects($this->any())
            ->method('getName')
            ->willReturn('test');

        $this->mocks[Club::class]
            ->expects($this->any())
            ->method('getBudget')
            ->willReturn(1234.4);

        $this->mocks[Club::class]
            ->expects($this->any())
            ->method('getCoach')
            ->willReturn($this->mocks[Coach::class]);
    }

    private function createPlayer()
    {
        $this->mocks[Player::class]
        ->expects($this->any())
        ->method('create');
    }

    private function addPlayer()
    {
        $this->mocks[PlayerRepositoryInterface::class]
        ->expects($this->once())
        ->method('add');
    }

    private function flushPlayer()
    {
        $this->mocks[PlayerRepositoryInterface::class]
        ->expects($this->once())
        ->method('flush');
    }

    private function findPlayer(bool $willThrowException = false)
    {
        if($willThrowException) {
            $this->mocks[PlayerRepositoryInterface::class]
                ->expects($this->once())
                ->method('find')
                ->willThrowException(new EntityNotFoundException($this->data->playerId, Player::class));
        } else {
            $this->mocks[PlayerRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Player::class]);
        }
    }

    public function testAddNewPlayer()
    {
        $this->data->playerId = null;

        $command        = new AddPlayer\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->createPlayer();
        $this->addPlayer();
        $this->flushClub();

        $commandHandler($command);
    }

    private function flushClub()
    {
        $this->mocks[ClubRepositoryInterface::class]
        ->expects($this->once())
        ->method('flush');
    }

    public function testAddNewPlayerInvalidName()
    {
        $this->data->playerId = null;
        $this->data->playerName = 'i';

        $command        = new AddPlayer\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->createPlayer();
        
        $this->expectException(InvalidPlayerNameException::class);

        $commandHandler($command);
    }

    public function testAddNewPlayerInvalidSalary()
    {
        $this->data->playerId = null;
        $this->data->salary = -100.5;

        $command        = new AddPlayer\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->createPlayer();
        
        $this->expectException(InvalidSalaryException::class);

        $commandHandler($command);
    }

    public function testAddNewPlayerInvalidPosition()
    {
        $this->data->playerId = null;
        $this->data->position = 'p';

        $command        = new AddPlayer\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->createPlayer();
        
        $this->expectException(InvalidPlayerPositionException::class);

        $commandHandler($command);
    }

    public function testUpdatePlayer()
    {
        $command        = new AddPlayer\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->findPlayer();
        $this->flushPlayer();

        $commandHandler($command);
    }

    public function testUpdatePlayerNotFound()
    {
        $command        = new AddPlayer\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->findPlayer(true);
        $this->expectException(EntityNotFoundException::class);

        $commandHandler($command);
    }

}
