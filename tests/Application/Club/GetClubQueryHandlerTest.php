<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use App\Application\Club\GetClub;
use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;

class GetClubQueryHandlerTest extends TestCase
{

    protected array $data;

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'clubId' => 1,
        ];

        $this->initMocks();
    }

    private function initMocks(): void
    {
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[Club::class]                       = $this->createMock(Club::class);
        $this->mocks[GetClub\Response::class]           = $this->createMock(GetClub\Response::class);
    }

    private function initQueryHandler(): GetClub\QueryHandler
    {
        return new GetClub\QueryHandler(
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    private function getClub(bool $willReturnNull = false) {
        if ($willReturnNull) {
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

    public function testBasicResponse() 
    {

        $queryHandler = $this->initQueryHandler();

        $this->getClub();

        $response = $queryHandler(new GetClub\Query($this->data));

        $this->assertInstanceOf(GetClub\Response::class, $this->mocks[GetClub\Response::class]);
        $this->assertEquals($response->getClub(), $this->mocks[Club::class]);
    }

    public function testClubNotFound() 
    {

        $queryHandler = $this->initQueryHandler();

        $this->getClub(true);

        $response = $queryHandler(new GetClub\Query($this->data));

        $this->assertInstanceOf(GetClub\Response::class, $this->mocks[GetClub\Response::class]);
        $this->assertEquals($response->getClub(), null);
    }

}
