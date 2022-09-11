<?php

namespace App\Domain\Coach;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Club\Club;

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
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\OneToOne(targetEntity=Club::class, inversedBy="coach", cascade={"persist", "remove"})
     */
    private $club;

    public function __construct(string $name, float $salary, ?Club $club)
    {
        $this->name     = $name;
        $this->salary   = $salary;
        $this->club     = $club;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }
}
