<?php

namespace App\Tests\Application\Position;

use App\Application\Position\GetPositions;
use App\Domain\Position\PositionRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GetPositionsQueryHandlerTest extends TestCase
{

    private array $mocks = [];
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[PositionRepositoryInterface::class]    = $this->createMock(PositionRepositoryInterface::class);
    }

    private function initHandler(): GetPositions\QueryHandler
    {
        return new GetPositions\QueryHandler(
            $this->mocks[PositionRepositoryInterface::class]
        );
    }

    public function testGetAllPositions()
    {
        $handler = $this->initHandler();

        $this->mocks[PositionRepositoryInterface::class]
            ->expects($this->once())
            ->method('findAll')
            ->willReturn(array());
        
        $response = $handler();

        $this->assertIsArray($response->getPositions());
        $this->assertEquals($response->getPositions(), []);
        $this->assertInstanceOf(GetPositions\Response::class, $response);
    }

}
