<?php

namespace App\Tests\Application\Club;

use App\Domain\Club\ClubRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Club\GetClubs;

class GetClubsQueryHandlerTest extends TestCase
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

    private function initHandler(): GetClubs\QueryHandler
    {
        return new GetClubs\QueryHandler(
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    private function findAllClubs(bool $willReturnNull = false)
    {
        if ($willReturnNull) {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('findAll')
            ->willReturn(null);
        } else {
            $this->mocks[ClubRepositoryInterface::class]
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);
        }
    }

    public function testGetclubs()
    {
        $this->findAllClubs();

        $handler = $this->initHandler();
        $response = $handler();

        $this->assertNotNull($response->getClubs());
        $this->assertIsArray($response->getClubs());
        $this->assertInstanceOf(GetClubs\Response::class, $response);
    }

    public function testGetNullArrayOfClubs()
    {
        $this->findAllClubs(true);

        $handler = $this->initHandler();
        $response = $handler();

        $this->assertNull($response->getClubs());
        $this->assertInstanceOf(GetClubs\Response::class, $response);
    }

}
