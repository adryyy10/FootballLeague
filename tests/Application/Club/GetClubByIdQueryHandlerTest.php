<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use App\Application\Club\GetClubById;
use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use stdClass;

class GetClubByIdQueryHandlerTest extends TestCase
{
    /*
    protected stdClass $data;

    protected array $mocks = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object)[
            'clubId'    => 1,
            'slug'      => 'test'
        ];

        $this->initMocks();
    }

    private function initMocks(): void
    {
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[Club::class]                       = $this->createMock(Club::class);
        $this->mocks[GetClubById\Response::class]       = $this->createMock(GetClubById\Response::class);
    }

    private function initQueryHandler(): GetClubById\QueryHandler
    {
        return new GetClubById\QueryHandler(
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    private function GetClubById(bool $willReturnNull = false) {
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

        $this->GetClubById();

        $response = $queryHandler(new GetClubById\Query($this->data));

        $this->assertInstanceOf(GetClubById\Response::class, $this->mocks[GetClubById\Response::class]);
        $this->assertEquals($response->getClub(), $this->mocks[Club::class]);
    }

    public function testClubNotFound() 
    {
        $queryHandler = $this->initQueryHandler();

        $this->GetClubById(true);

        $response = $queryHandler(new GetClubById\Query($this->data));

        $this->assertInstanceOf(GetClubById\Response::class, $this->mocks[GetClubById\Response::class]);
        $this->assertEquals($response->getClub(), null);
    }
    */
}
