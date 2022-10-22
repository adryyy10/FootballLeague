<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Club\DeleteClub;
use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Exceptions\EntityNotFoundException;

class DeleteClubCommandHandlerTest extends TestCase
{

    protected stdClass $data;

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = (object) [
            'clubId' => 1
        ];

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[ClubRepositoryInterface::class] = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[Club::class] = $this->createMock(Club::class);
    }

    private function initHandler(): DeleteClub\CommandHandler
    {
        return new DeleteClub\CommandHandler(
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    private function getClub(bool $willThrowException = false)
    {
        if ($willThrowException) {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);
        } else {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Club::class]);
        }
    }

    public function testDeleteClub()
    {
        $handler = $this->initHandler();
        $command = new DeleteClub\Command($this->data);

        $this->getClub();

        $handler($command);
    }

    public function testClubNotFound()
    {
        $handler = $this->initHandler();
        $command = new DeleteClub\Command($this->data);

        $this->getClub(true);

        $this->expectException(EntityNotFoundException::class);
        $handler($command);
    }

}
