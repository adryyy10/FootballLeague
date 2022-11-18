<?php

namespace App\Tests\Application\Coach;

use App\Application\Coach\AddCoach\Command;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

class AddCoachCommandTest extends TestCase
{

    public stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = (object)[
            'coachId'   => 1,
            'coachName' => 'testCoachName',
            'salary'    => 12345.9
        ];
    }

    public function testGetValidQuery()
    {
        $command = new Command($this->data);

        $this->assertIsInt($command->getCoachId());
        $this->assertIsString($command->getCoachName());
        $this->assertIsFloat($command->getSalary());
    }

    public function testInvalidCoachName()
    {
        $this->data->coachName = 1;

        $this->expectException(InvalidArgumentException::class);
        new Command($this->data);
    }

    public function testInvalidSalary()
    {
        $this->data->salary = 123;

        $this->expectException(InvalidArgumentException::class);
        new Command($this->data);
    }

    public function testInvalidCoachId()
    {
        $this->data->coachId = '';

        $this->expectException(InvalidArgumentException::class);
        new Command($this->data);
    }

}

