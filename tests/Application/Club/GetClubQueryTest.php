<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use App\Application\Club\GetClub;
use InvalidArgumentException;
use stdClass;

class GetClubQueryTest extends TestCase
{

    public function testValidQuery()
    {
        $data = new stdClass;
        $data->clubId = 135;

        $query = new GetClub\Query($data);

        $this->assertInstanceOf(GetClub\Query::class, $query);
        $this->assertEquals($data->clubId, $query->getClubId());
        $this->assertIsInt($query->getClubId());
    }

    public function testClubIdNull()
    {
        $data = new stdClass;
        $data->clubId = null;

        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Expected an integer. Got: NULL');
        new GetClub\Query((object)$data);
    }

    public function testClubIdNotInteger()
    {
        $data = new stdClass;
        $data->clubId = '';

        $this->expectException(InvalidArgumentException::class);
        $this->expectErrorMessage('Expected an integer. Got: string');
        new GetClub\Query((object)$data);
    }

}
