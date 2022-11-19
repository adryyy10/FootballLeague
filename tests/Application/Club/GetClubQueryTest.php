<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use App\Application\Club\GetClub;
use InvalidArgumentException;
use stdClass;

class GetClubQueryTest extends TestCase
{

    private stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = (object)[
            'clubId' => 1
        ];
    }

    public function testValidQuery()
    {
        $this->data->clubId = 135;

        $query = new GetClub\Query($this->data);

        $this->assertInstanceOf(GetClub\Query::class, $query);
        $this->assertEquals($this->data->clubId, $query->getClubId());
        $this->assertIsInt($this->data->clubId);
    }

    public function testClubIdNull()
    {
        $this->data->clubId = null;

        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Expected an integer. Got: NULL');
        new GetClub\Query($this->data);
    }

    public function testClubIdNotInteger()
    {
        $this->data->clubId = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Expected an integer. Got: string');
        new GetClub\Query($this->data);
    }

}
