<?php

namespace App\Tests\Application\Player;

use PHPUnit\Framework\TestCase;
use App\Application\Player\GetPlayers;
use App\Domain\Player\PlayerRepositoryInterface;

class GetPlayersQueryHandlerTest extends TestCase
{

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[PlayerRepositoryInterface::class] = $this->createMock(PlayerRepositoryInterface::class); 
    }

    private function initHandler(): GetPlayers\QueryHandler
    {
        return new GetPlayers\QueryHandler(
            $this->mocks[PlayerRepositoryInterface::class]
        );
    }

    public function testGetClubs()
    {

        $this->mocks[PlayerRepositoryInterface::class]
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);        

        $useCase = $this->initHandler();

        $response = $useCase();

        $this->assertIsArray($response->getPlayers());
        $this->assertEmpty($response->getPlayers());
    }

}
