<?php

namespace App\Domain\Coach;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Club\Club;
use App\Domain\Exceptions\Coach\InvalidCoachIdException;
use App\Domain\Exceptions\Coach\InvalidCoachNameException;
use App\Domain\Exceptions\Coach\InvalidSalaryException;

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


    /**
     * This method validate the business logic from the Entity
     */
    public static function validateBusinessModel(
        ?int $id,
        string $name = '',
        float $salary = 0.0
    ): void {

        if (!empty($id) && $id < 0) {
            throw new InvalidCoachIdException();
        }

        if (!empty($name) && strlen($name) <= 2) {
            throw new InvalidCoachNameException();
        }

        if (!empty($salary) && $salary < 0) {
            throw new InvalidSalaryException();
        }
    }

    public static function create(
        string $name,
        float $salary
    ): Coach
    {
        /** Validate business model before anything else */
        self::validateBusinessModel(
            null, 
            $name, 
            $salary
        );

        $coach = new Coach(
            $name,
            $salary
        );

        return $coach;
    }

    public static function update(
        Coach $coach,
        string $name,
        float $salary
    ): void
    {
        /** Validate business model before anything else */
        self::validateBusinessModel(
            $coach->getId(), 
            $name, 
            $salary
        );

        $coach->setName($name);
        $coach->setSalary($salary);
    }
}
