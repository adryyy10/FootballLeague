<?php

namespace App\Domain\Player;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Club\Club;
use App\Domain\Exceptions\Coach\InvalidSalaryException;
use App\Domain\Exceptions\Player\InvalidPlayerIdException;
use App\Domain\Exceptions\Player\InvalidPlayerNameException;
use App\Domain\Exceptions\Player\InvalidPlayerPositionException;

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
        float $salary,
        ?Club $club
    )
    {
        $this->name     = $name;
        $this->position = $position;
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

    private function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public static function validateBusinessModel(
        ?int $id,
        string $name = '',
        string $position = '',
        float $salary = 0.0
    ): void {
        
        if (!empty($id) && $id < 0) {
            throw new InvalidPlayerIdException();
        }

        if (!empty($name) && strlen($name) < 2) {
            throw new InvalidPlayerNameException();
        }

        if (!empty($salary) && $salary < 0) {
            throw new InvalidSalaryException();
        }

        if (!empty($position) && strlen($position) < 2) {
            throw new InvalidPlayerPositionException();
        }
    }

    public static function create(
        string $name,
        string $position,
        string $salary,
        ?Club $club
    ): Player
    {
        /** Validate business logic */
        self::validateBusinessModel(null, $name, $position, $salary);

        $player = new Player(
            $name,
            $position,
            $salary,
            $club
        );

        return $player;
    }

    public static function update(
        Player $player,
        string $name,
        string $position,
        string $salary,
        ?Club $club
    ): void
    {

        /** Validate business logic */
        self::validateBusinessModel(null, $name, $position, $salary);

        $player->setName($name);
        $player->setPosition($position);
        $player->setSalary($salary);
        $player->setClub($club);
    }
}
