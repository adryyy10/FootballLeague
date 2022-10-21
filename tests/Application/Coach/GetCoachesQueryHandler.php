<?php

namespace App\Tests\Application\Coach;

use PHPUnit\Framework\TestCase;
use App\Application\Coach\GetCoaches;
use App\Domain\Coach\CoachRepositoryInterface;

class GetCoachesQueryHandler extends TestCase
{

    private array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->initMocks();
    }

    private function initMocks()
    {
        $this->mocks[CoachRepositoryInterface::class] = $this->createMock(CoachRepositoryInterface::class);
    }

    private function initHandler(): GetCoaches\QueryHandler
    {
        return new GetCoaches\QueryHandler(
            $this->mocks[CoachRepositoryInterface::class]
        );
    }

    public function testBasicResponse()
    {
        $useCase = $this->initHandler();

        $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $response = $useCase();

        $this->assertIsArray($response->getCoaches());
    }

}
