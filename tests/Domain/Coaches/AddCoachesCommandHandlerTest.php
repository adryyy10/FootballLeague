<?php

namespace App\Tests\Domain\Coaches;

use App\Domain\Club\ClubRepositoryInterface;
use App\Domain\Coach\CoachRepositoryInterface;
use PHPUnit\Framework\TestCase;
use App\Application\Coach\AddCoaches;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\EmptyCoachNameException;
use App\Domain\Exceptions\EmptySalaryException;
use App\Domain\Exceptions\EntityNotFoundException;


class AddCoachesCommandHandlerTest extends TestCase
{

    protected array $data;

    protected array $mocks;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mocks = [];

        $this->data = [
            'coachId'   => 1,
            'coachName' => 'Guardiola',
            'salary'    => 12345,
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
        return new AddCoaches\CommandHandler(
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
        $this->data['coachId']    = null;
        $this->data['coachName']  = '';
        $useCase = $this->initUseCase();

        $this->expectException(EmptyCoachNameException::class);
        $useCase(new AddCoaches\Command($this->data));
    }

    public function testAddNewCoachWithEmptySalary()
    {
        $this->data['coachId']  = null;
        $this->data['salary']   = 0;
        $useCase = $this->initUseCase();

        $this->expectException(EmptySalaryException::class);
        $useCase(new AddCoaches\Command($this->data));
    }

    public function testUpdateCoachWithEmptyId()
    {
        $this->data['coachId']  = 99999;

        $this->getCoach(false);

        $useCase = $this->initUseCase();

        $this->expectException(EntityNotFoundException::class);
        $useCase(new AddCoaches\Command($this->data));
    }

}
