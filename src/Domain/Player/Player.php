<?php

namespace App\Domain\Player;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Club\Club;


/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
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
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="players")
     */
    private $club;

    private function __construct(
        string $name,
        string $position,
        float $salary
    )
    {
        $this->name     = $name;
        $this->position = $position;
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

    public function getPosition(): ?string
    {
        return $this->position;
    }

    private function setPosition(string $position): self
    {
        $this->position = $position;

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

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public static function create(
        string $name,
        string $position,
        string $salary
    ): Player
    {
        $player = new Player(
            $name,
            $position,
            $salary
        );

        return $player;
    }

    public static function update(
        Player $player,
        string $name,
        string $position,
        string $salary
    ): void
    {
        $player->setName($name);
        $player->setPosition($position);
        $player->setSalary($salary);
    }
}
