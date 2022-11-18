<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Club\AddClub;
use InvalidArgumentException;

class AddClubQueryTest extends TestCase
{

    private function generateClubData(): stdClass
    {
        return (object) [
            'clubId' => 1,
            'clubName' => 'test',
            'budget'   => 12345.8,
            'coachId'  => 1
        ];
    }

    private function generateQuery(stdClass $data): AddClub\Command
    {
        return new AddClub\Command($data);
    }

    public function testValidQueryWithClubId()
    {
        $data   = $this->generateClubData();
        $query  = $this->generateQuery($data);

        $this->assertEquals($query->getClubId(), $data->clubId);
        $this->assertEquals($query->getClubName(), $data->clubName);
        $this->assertEquals($query->getBudget(), $data->budget);
        $this->assertEquals($query->getCoachId(), $data->coachId);

        $this->assertIsInt($query->getClubId());
        $this->assertIsString($query->getClubName());
        $this->assertIsFloat($query->getBudget());
        $this->assertIsInt($query->getCoachId());
    }

    public function testValidQueryWithoutClubId()
    {
        $data   = $this->generateClubData();
        $query  = $this->generateQuery($data);

        $this->assertEquals($query->getClubName(), $data->clubName);
        $this->assertEquals($query->getBudget(), $data->budget);
        $this->assertEquals($query->getCoachId(), $data->coachId);
        
        $this->assertIsString($query->getClubName());
        $this->assertIsFloat($query->getBudget());
        $this->assertIsInt($query->getCoachId());
    }

    public function testInvalidClubId()
    {
        $data = $this->generateClubData();
        $data->clubId = 0;

        $this->expectException(InvalidArgumentException::class);
        $query = $this->generateQuery($data);
    }

    public function testInvalidClubName()
    {
        $data = $this->generateClubData();
        $data->clubName = null;

        $this->expectException(InvalidArgumentException::class);
        $this->generateQuery($data);
    }

    public function testInvalidCoachId()
    {
        $data = $this->generateClubData();
        $data->coachId = null;

        $this->expectException(InvalidArgumentException::class);
        $this->generateQuery($data);
    }

}
