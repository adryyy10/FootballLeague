<?php

namespace App\Domain\Coach;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Exceptions\EmptyCoachNameException;
use App\Domain\Exceptions\EmptySalaryException;
use App\Domain\Club\Club;
use App\Domain\Exceptions\InvalidCoachIdException;
use App\Domain\Exceptions\InvalidCoachNameException;
use App\Domain\Exceptions\InvalidSalaryException;

/**
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 */
class Coach
{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @ORM\Column(type="float")
     */
    public $salary;

    /**
     * One coach has one club
     * 
     * @ORM\OneToOne(targetEntity=Club::class, mappedBy="coach", cascade={"persist"})
     */
    public $club;

    private function __construct(string $name, float $salary)
    {
        $this->name     = $name;
        $this->salary   = $salary;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    private function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    private function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public static function create(
        string $coachName,
        float $salary
    ): Coach
    {
        if (empty($coachName) || strlen($coachName) < 3) {
            throw new InvalidCoachNameException();
        }

        if (empty($salary) || !is_numeric($salary)) {
            throw new InvalidSalaryException();
        }

        $coach = new Coach(
            $coachName,
            $salary
        );

        return $coach;
    }

    public static function update(
        Coach $coach,
        string $coachName,
        float $salary
    ): void
    {

        if ($coach->getId() < 0) {
            throw new InvalidCoachIdException();
        }

        if (strlen($coachName) <= 2) {
            throw new InvalidCoachNameException();
        }

        if ($salary < 0) {
            throw new InvalidCoachNameException();
        }

        $coach->setName($coachName);
        $coach->setSalary($salary);
    }
}
