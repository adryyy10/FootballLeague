<?php

namespace App\Tests\Application\Coach;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\CoachRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Coach\DeleteCoach;
use App\Domain\Club\Club;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\EmptyCoachIdException;
use App\Domain\Exceptions\EntityNotFoundException;
use phpDocumentor\Reflection\Types\Void_;
use SebastianBergmann\Type\VoidType;
use stdClass;

class DeleteCoachCommandHandlerTest extends TestCase
{

    protected array $mocks = [];

    protected stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object) [
            'coachId' => 1
        ];

        $this->initMocks();
    }

    private function initMocks(): void
    {
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[CoachRepositoryInterface::class]   = $this->createMock(CoachRepositoryInterface::class);
        $this->mocks[Coach::class]                      = $this->createMock(Coach::class);
        $this->mocks[Club::class]                       = $this->createMock(Club::class);
    }

    private function initHandler(): DeleteCoach\CommandHandler
    {
        return new DeleteCoach\CommandHandler(
            $this->mocks[CoachRepositoryInterface::class],
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    private function findCoach(bool $willThrowException = false)
    {
        if ($willThrowException) {
            $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);
        } else {
            $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Coach::class]);
        }
    }

    public function getClubByCoach(bool $willThrowException = false)
    {
        if ($willThrowException) {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('findOneByCoachId')
            ->willReturn(null);
        } else {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('findOneByCoachId')
            ->willReturn($this->mocks[Club::class]);
        }
    }

    public function testDeleteCoachWithoutClub()
    {
        $command = new DeleteCoach\Command($this->data);

        $this->findCoach();

        $this->getClubByCoach(true);

        $handler = $this->initHandler();

        $handler($command);
    }

    public function testEntityNotFoundException()
    {
        $command = new DeleteCoach\Command($this->data);

        $this->findCoach(true);

        $this->expectException(EntityNotFoundException::class);
        $handler = $this->initHandler();

        $handler($command);
    } 

    public function testInvalidCoachId()
    {
        $this->data->coachId = -1;

        $command = new DeleteCoach\Command($this->data);

        $this->expectException(EmptyCoachIdException::class);
        $handler = $this->initHandler();

        $handler($command);
    }

}
