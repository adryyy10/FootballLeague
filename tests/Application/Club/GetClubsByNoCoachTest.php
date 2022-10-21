<?php

namespace App\Tests\Application\Club;

use App\Domain\Club\ClubRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Club\GetClubsWithNoCoach;

class GetClubsByNoCoachTest extends TestCase
{

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[ClubRepositoryInterface::class] = $this->createMock(ClubRepositoryInterface::class);
    }

    private function initHandler(): GetClubsWithNoCoach\QueryHandler
    {
        return new GetClubsWithNoCoach\QueryHandler(
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    public function testGetClubsWithNoCoach()
    {
        $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('findByNoCoach')
            ->willReturn([]);

        $handler = $this->initHandler();
        $response = $handler();

        $this->assertNotNull($response->getClubs());
        $this->assertIsArray($response->getClubs());
        $this->assertInstanceOf(GetClubsWithNoCoach\Response::class, $response);
    }

}
