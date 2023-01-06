<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Club\AddClub;
use InvalidArgumentException;

class AddClubCommandTest extends TestCase
{

    private stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = (object)[
            'clubId'    => 1,
            'clubName'  => 'test',
            'budget'    => 12345.8,
            'coachId'   => 1,
            'stadiumId' => 1,
            'palette'   => '#FFFFFF'
        ];
    }

    private function generateQuery(stdClass $data): AddClub\Command
    {
        return new AddClub\Command($data);
    }

    public function testValidQueryWithClubId()
    {
        $query  = $this->generateQuery($this->data);

        $this->assertEquals($query->getClubId(), $this->data->clubId);
        $this->assertEquals($query->getClubName(), $this->data->clubName);
        $this->assertEquals($query->getBudget(), $this->data->budget);
        $this->assertEquals($query->getCoachId(), $this->data->coachId);
        $this->assertEquals($query->getStadiumId(), $this->data->stadiumId);
        $this->assertEquals($query->getPalette(), $this->data->palette);

        $this->assertIsInt($query->getClubId());
        $this->assertIsString($query->getClubName());
        $this->assertIsFloat($query->getBudget());
        $this->assertIsInt($query->getCoachId());
        $this->assertIsInt($query->getStadiumId());
        $this->assertIsString($query->getPalette());
    }

    public function testValidQueryWithoutClubId()
    {
        $query  = $this->generateQuery($this->data);

        $this->assertEquals($query->getClubName(), $this->data->clubName);
        $this->assertEquals($query->getBudget(), $this->data->budget);
        $this->assertEquals($query->getCoachId(), $this->data->coachId);
        $this->assertEquals($query->getStadiumId(), $this->data->stadiumId);
        $this->assertEquals($query->getPalette(), $this->data->palette);
        
        $this->assertIsString($query->getClubName());
        $this->assertIsFloat($query->getBudget());
        $this->assertIsInt($query->getCoachId());
        $this->assertIsInt($query->getStadiumId());
        $this->assertIsString($query->getPalette());
    }

    public function testInvalidClubId()
    {
        $this->data->clubId = '';

        $this->expectException(InvalidArgumentException::class);
        $this->generateQuery($this->data);
    }

    public function testInvalidClubName()
    {
        $this->data->clubName = null;

        $this->expectException(InvalidArgumentException::class);
        $this->generateQuery($this->data);
    }

    public function testInvalidCoachId()
    {
        $this->data->coachId = null;

        $this->expectException(InvalidArgumentException::class);
        $this->generateQuery($this->data);
    }

}
