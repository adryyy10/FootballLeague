<?php

namespace App\Tests\Application\Coach;

use App\Domain\Coach\CoachRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Coach\GetCoach;
use App\Domain\Coach\Coach;
use stdClass;

class GetCoachQueryHandler extends TestCase
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

    private function initMocks()
    {
        $this->mocks[CoachRepositoryInterface::class] = $this->createMock(CoachRepositoryInterface::class);
        $this->mocks[Coach::class] = $this->createMock(Coach::class);
    }

    private function initHandler(): GetCoach\QueryHandler
    {
        return new GetCoach\QueryHandler(
            $this->mocks[CoachRepositoryInterface::class]
        );
    }

    private function getCoach(bool $willGetCoach = true)
    {
        if ($willGetCoach) {
            $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->mocks[Coach::class]);
        } else {
            $this->mocks[CoachRepositoryInterface::class]
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);
        }
    }

    public function testBasicResponse()
    {
        $useCase    = $this->initHandler();
        $query      = new GetCoach\Query($this->data);

        $this->getCoach();

        $response = $useCase($query);

        $this->assertInstanceOf(GetCoach\Response::class, $response);
        $this->assertInstanceOf(Coach::class, $response->getCoach());
        $this->assertNotNull($response->getCoach());
    }

    public function testCoachNotFound()
    {
        $useCase    = $this->initHandler();
        $query      = new GetCoach\Query($this->data);

        $this->getCoach(false);

        $response = $useCase($query);

        $this->assertNull($response->getCoach());
    }

}
