<?php

namespace App\Tests\Application\Club;

use App\Domain\Stadium\StadiumRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Stadium\GetStadiums;

class GetStadiumsQueryHandlerTest extends TestCase
{

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[StadiumRepositoryInterface::class] = $this->createMock(StadiumRepositoryInterface::class); 
    }

    private function initHandler(): GetStadiums\QueryHandler
    {
        return new GetStadiums\QueryHandler(
            $this->mocks[StadiumRepositoryInterface::class]
        );
    }

    private function findAllStadiums()
    {
        $this->mocks[StadiumRepositoryInterface::class]
        ->expects($this->once())
        ->method('findAll')
        ->willReturn([]);
    }

    public function testGetStadiums()
    {
        $this->findAllStadiums();

        $handler = $this->initHandler();
        $response = $handler();

        $this->assertNotNull($response->getStadiums());
        $this->assertIsArray($response->getStadiums());
        $this->assertInstanceOf(GetStadiums\Response::class, $response);
    }

}
