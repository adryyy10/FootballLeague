<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use App\Application\Club\AddClub;
use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\Coach;
use App\Domain\Coach\CoachRepositoryInterface;
use App\Domain\Exceptions\EntityNotFoundException;
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
            'coachId'   => 1
        ];

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[CoachRepositoryInterface::class]   = $this->createMock(CoachRepositoryInterface::class);
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[Club::class]                       = $this->createMock(Club::class);
        $this->mocks[Coach::class]                      = $this->createMock(Coach::class);
    }

    public function initHandler(): AddClub\CommandHandler
    {
        return new AddClub\CommandHandler(
            $this->mocks[CoachRepositoryInterface::class],
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    public function testUpdateClubNotFound()
    {
        $this->data->clubId = 999999;

        $command        = new AddClub\Command($this->data);

        $this->mocks[ClubRepositoryInterface::class]
        ->expects($this->once())
        ->method('find')
        ->willThrowException(new EntityNotFoundException('0', Club::class));

        $commandHandler = $this->initHandler();

        $this->expectException(EntityNotFoundException::class);
        $commandHandler($command);
    }

}
