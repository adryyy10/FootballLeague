<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use App\Application\Club\AddClub;
use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Stadium\Stadium;
use App\Domain\Stadium\StadiumRepositoryInterface;
use stdClass;

class AddClubCommandHandlerTest extends TestCase
{

    protected stdClass $data;

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object) [
            'clubId'    => 1,
            'clubName'  => 'test',
            'budget'    => 12345.8,
            'coachId'   => 1,
            'stadiumId' => 1,
            'palette'   => '#FFFFFF'
        ];

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[CoachRepositoryInterface::class]   = $this->createMock(CoachRepositoryInterface::class);
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[StadiumRepositoryInterface::class] = $this->createMock(StadiumRepositoryInterface::class);
        $this->mocks[Club::class]                       = $this->createMock(Club::class);
        $this->mocks[Coach::class]                      = $this->createMock(Coach::class);
        $this->mocks[Stadium::class]                    = $this->createMock(Stadium::class);
    }

    public function initHandler(): AddClub\CommandHandler
    {
        return new AddClub\CommandHandler(
            $this->mocks[CoachRepositoryInterface::class],
            $this->mocks[ClubRepositoryInterface::class],
            $this->mocks[StadiumRepositoryInterface::class]
        );
    }

    public function findClub(bool $willThrowException = false)
    {
        if ($willThrowException) {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new EntityNotFoundException('0', Club::class));
        } else {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Club::class]);
        }
    }

    public function findCoach(bool $willThrowException = false)
    {
        if ($willThrowException) {
            $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new EntityNotFoundException($this->data->coachId, Coach::class));
        } else {
            $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Coach::class]);
        }
    }


    public function findStadium(bool $willThrowException = false)
    {
        if ($willThrowException) {
            $this->mocks[StadiumRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willThrowException(new EntityNotFoundException($this->data->stadiumId, Stadium::class));
        } else {
            $this->mocks[StadiumRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Stadium::class]);
        }
    }

    public function testAddClub()
    {
        $this->data->clubId = null;

        $command        = new AddClub\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->findCoach();
        $this->findStadium();

        $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('add');

        $commandHandler($command);
    }

    public function testUpdateClub()
    {
        $command        = new AddClub\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->findCoach();
        $this->findStadium();
        $this->findClub();

        $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('flush');

        $commandHandler($command);
    }

    public function testCoachNotFound()
    {
        $command        = new AddClub\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->findCoach(true);
        $this->expectException(EntityNotFoundException::class);

        $commandHandler($command);
    }

    public function testStadiumNotFound()
    {
        $command        = new AddClub\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->findCoach();
        $this->findStadium(true);
        $this->expectException(EntityNotFoundException::class);

        $commandHandler($command);
    }

    public function testUpdateClubNotFound()
    {
        $this->data->clubId = 999999;

        $command        = new AddClub\Command($this->data);
        $commandHandler = $this->initHandler();

        $this->findCoach();
        $this->findStadium();
        $this->findClub(true);
        $this->expectException(EntityNotFoundException::class);
        
        $commandHandler($command);
    }

}
