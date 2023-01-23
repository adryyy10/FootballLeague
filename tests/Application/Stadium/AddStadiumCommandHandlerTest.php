<?php

namespace App\Tests\Application\Stadium;

use App\Application\Stadium\AddStadium;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Exceptions\Stadium\InvalidStadiumAddressException;
use App\Domain\Exceptions\Stadium\InvalidStadiumBuiltException;
use App\Domain\Exceptions\Stadium\InvalidStadiumCapacityException;
use App\Domain\Exceptions\Stadium\InvalidStadiumNameException;
use App\Domain\Stadium\Stadium;
use App\Domain\Stadium\StadiumRepositoryInterface;
use PHPUnit\Framework\TestCase;
use stdClass;

class AddStadiumCommandHandlerTest extends TestCase
{

    protected stdClass $data;

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object)[
            'stadiumId'     => 1,
            'stadiumName'   => 'test',
            'capacity'      => 100,
            'built'         => 1947,
            'address'       => 'test'
        ];

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[StadiumRepositoryInterface::class]  = $this->createMock(StadiumRepositoryInterface::class);
        $this->mocks[Stadium::class]                     = $this->createMock(Stadium::class);
    }

    private function initHandler(): AddStadium\CommandHandler
    {
        return new AddStadium\CommandHandler(
            $this->mocks[StadiumRepositoryInterface::class]
        );
    }

    private function createStadium()
    {
        $this->mocks[Stadium::class]
        ->expects($this->any())
        ->method('create');
    }

    private function addStadium()
    {
        $this->mocks[StadiumRepositoryInterface::class]
        ->expects($this->once())
        ->method('add');
    }

    private function findStadium(bool $willThrowException = false)
    {
        if($willThrowException) {
            $this->mocks[StadiumRepositoryInterface::class]
                ->expects($this->once())
                ->method('find')
                ->willThrowException(new EntityNotFoundException($this->data->playerId, Stadium::class));
        } else {
            $this->mocks[StadiumRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Stadium::class]);
        }
    }

    public function testAddNewStadium()
    {
        $this->data->stadiumId = null;

        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->createStadium();
        $this->addStadium();

        $commandHandler($command);
    }

    public function testAddNewStadiumInvalidName()
    {
        $this->data->stadiumId      = null;
        $this->data->stadiumName    = 'i';

        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->createStadium();
        
        $this->expectException(InvalidStadiumNameException::class);

        $commandHandler($command);
    }

    public function testAddNewStadiumInvalidCapacity()
    {
        $this->data->stadiumId = null;
        $this->data->capacity = -100;

        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->createStadium();
        
        $this->expectException(InvalidStadiumCapacityException::class);

        $commandHandler($command);
    }

    public function testAddNewStadiumInvalidBuilt()
    {
        $this->data->stadiumId = null;
        $this->data->built = -100;

        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->createStadium();
        
        $this->expectException(InvalidStadiumBuiltException::class);

        $commandHandler($command);
    }

    public function testAddNewStadiumInvalidAddress()
    {
        $this->data->stadiumId      = null;
        $this->data->address    = 'i';

        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->createStadium();
        
        $this->expectException(InvalidStadiumAddressException::class);

        $commandHandler($command);
    }


    /*public function testUpdatePlayer()
    {
        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->findPlayer();
        $this->flushPlayer();

        $commandHandler($command);
    }

    public function testUpdatePlayerNotFound()
    {
        $command        = new AddStadium\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->getClub();
        $this->findPlayer(true);
        $this->expectException(EntityNotFoundException::class);

        $commandHandler($command);
    }*/

}
