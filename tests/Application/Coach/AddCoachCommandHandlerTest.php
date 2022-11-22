<?php

namespace App\Tests\Application\Coach;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\CoachRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Coach\AddCoach;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\EntityNotFoundException;
use App\Domain\Exceptions\Coach\InvalidCoachNameException;
use App\Domain\Exceptions\Coach\InvalidSalaryException;
use stdClass;

class AddCoachCommandHandlerTest extends TestCase
{

    protected stdClass $data;

    protected array $mocks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mocks = [];

        $this->data = (object)[
            'coachId'   => null,
            'coachName' => 'Guardiola',
            'salary'    => 12345.5,
            'clubId'    => null
        ];

        $this->initMocks();
    }

    protected function initMocks()
    {
        $this->mocks[CoachRepositoryInterface::class]   = $this->createMock(CoachRepositoryInterface::class);
        $this->mocks[ClubRepositoryInterface::class]    = $this->createMock(ClubRepositoryInterface::class);
        $this->mocks[Coach::class]                      = $this->createMock(Coach::class);
    }

    protected function initUseCase()
    {
        return new AddCoach\CommandHandler(
            $this->mocks[CoachRepositoryInterface::class],
            $this->mocks[ClubRepositoryInterface::class]
        );
    }

    protected function getCoach(bool $isCoachFound = true)
    {
        if ($isCoachFound) {
            $this->mocks[CoachRepositoryInterface::class]
                ->expects($this->once())
                ->method('find')
                ->willReturn($this->mocks[Coach::class]);
        } else {
            $this->mocks[CoachRepositoryInterface::class]
                ->expects($this->once())
                ->method('find')
                ->willThrowException(new EntityNotFoundException('0', Coach::class));
        }
    }

    public function testAddNewCoachWithEmptyName()
    {
        $this->data->coachName  = 'hi';
        $useCase = $this->initUseCase();

        $this->expectException(InvalidCoachNameException::class);
        $useCase(new AddCoach\Command($this->data));
    }

    public function testAddNewCoachWithInvalidSalary()
    {
        $this->data->salary   = -1.1;
        $useCase = $this->initUseCase();

        $this->expectException(InvalidSalaryException::class);
        $useCase(new AddCoach\Command($this->data));
    }

    public function testUpdateCoachNotFound()
    {
        $this->data->coachId  = 1;

        $this->getCoach(false);

        $useCase = $this->initUseCase();

        $this->expectException(EntityNotFoundException::class);
        $useCase(new AddCoach\Command($this->data));
    }

}
