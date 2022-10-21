<?php

namespace App\Tests\Application\Coach;

use PHPUnit\Framework\TestCase;
use App\Application\Coach\GetCoach;
use InvalidArgumentException;
use stdClass;

class GetCoachQuery extends TestCase
{

    protected stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object) [
            'coachId' => 1
        ];

    }

    public function testValidQuery()
    {
        $query = new GetCoach\Query($this->data);

        $this->assertNotNull($query->getCoachId());
        $this->assertIsInt($query->getCoachId());
        $this->assertEquals($query->getCoachId(), $this->data->coachId);
    }

    public function testInvalidCoachId()
    {
        $this->data->coachId = -1;

        $this->expectException(InvalidArgumentException::class);
        new GetCoach\Query($this->data);
    }

    public function testNullCoachId()
    {
        $this->data->coachId = null;

        $this->expectException(InvalidArgumentException::class);
        new GetCoach\Query($this->data);
    }

}
