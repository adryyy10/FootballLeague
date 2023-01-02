<?php

namespace App\Domain\Club;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\Club\InvalidClubBudgetException;
use App\Domain\Exceptions\Club\InvalidClubIdException;
use App\Domain\Exceptions\Club\InvalidClubNameException;
use App\Domain\Player\Player;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
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
    private $budget;

    /**
     * One club has one coach
     * 
     * @ORM\OneToOne(targetEntity=Coach::class, inversedBy="club", cascade={"persist"})
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="id", nullable=true)
     */
    private $coach;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="club")
     */
    private $players;

    private function __construct(
        string $name,
        float $budget,
        Coach $coach
    ) {
        $this->name     = $name;
        $this->budget   = $budget;
        $this->coach    = $coach;
        $this->players  = new ArrayCollection();
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

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    private function setBudget(float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    private function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setClub($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getClub() === $this) {
                $player->setClub(null);
            }
        }

        return $this;
    }

    /**
     * This method validate the business logic from the Entity
     */
    public static function validateBusinessModel(
        ?int $id,
        string $name = '',
        float $budget = 0.0
    ): void {
        if (!empty($id) && $id < 0) {
            throw new InvalidClubIdException();
        }

        if (!empty($name) && strlen($name) <= 2) {
            throw new InvalidClubNameException();
        }

        if (!empty($budget) && $budget < 0) {
            throw new InvalidClubBudgetException();
        }
    }

    public static function create(
        string $name,
        float $budget,
        Coach $coach
    ): Club
    {

        /** Validate business model before anything else */
        self::validateBusinessModel(
            null,
            $name,
            $budget
        );

        $club = new Club(
            $name,
            $budget,
            $coach
        );

        return $club;
    }

    public static function update(
        Club $club,
        string $name,
        float $budget,
        Coach $coach
    ): void
    {

        /** Validate business model before anything else */
        self::validateBusinessModel(
            $club->getId(),
            $name,
            $budget
        );

        $club->setName($name);
        $club->setBudget($budget);
        $club->setCoach($coach);
    }

    public static function setCoachToNull(Club $club): void
    {
        $club->setCoach(null);
    }
}
