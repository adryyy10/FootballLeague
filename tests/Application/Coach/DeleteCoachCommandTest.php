<?php

namespace App\Tests\Application\Coach;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Coach\DeleteCoach;
use InvalidArgumentException;

class DeleteCoachCommandTest extends TestCase
{

    protected stdClass $data;

    protected function setUp(): void
    {
        $this->data = (object) [
            'coachId' => 1
        ];
    }

    public function testValidCommand()
    {
        $command = new DeleteCoach\Command($this->data);

        $this->assertEquals($command->getCoachId(), $this->data->coachId);
        $this->assertIsInt($command->getCoachId());
    }

    public function testInvalidCoachId()
    {
        $this->data->coachId = -1;

        $this->expectException(InvalidArgumentException::class);
        new DeleteCoach\Command($this->data);
    }

    public function testNullCoachId()
    {
        $this->data->coachId = null;

        $this->expectException(InvalidArgumentException::class);
        new DeleteCoach\Command($this->data);
    }
}
