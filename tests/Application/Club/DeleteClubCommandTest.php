<?php

namespace App\Tests\Application\Club;

use PHPUnit\Framework\TestCase;
use stdClass;
use App\Application\Club\DeleteClub;
use InvalidArgumentException;

class DeleteClubCommandTest extends TestCase
{

    protected stdClass $data;

    protected function setUp(): void
    {
        parent::setUp();
        $this->data = (object) [
            'clubId' => 1
        ];
    }

    public function testValidCommand()
    {
        $command = new DeleteClub\Command($this->data);

        $this->assertEquals($this->data->clubId, $command->getClubId());
        $this->assertIsInt($command->getClubId());
    }

    public function testInvalidClubId()
    {
        $this->data->clubId = -1;

        $this->expectException(InvalidArgumentException::class);
        new DeleteClub\Command($this->data);
    }

}
