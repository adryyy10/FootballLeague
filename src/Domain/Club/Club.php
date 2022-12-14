<?php

namespace App\Domain\Club;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Coach\Coach;
use App\Domain\Exceptions\Club\InvalidClubBudgetException;
use App\Domain\Exceptions\Club\InvalidClubIdException;
use App\Domain\Exceptions\Club\InvalidClubNameException;
use App\Domain\Exceptions\Club\InvalidClubSlugException;
use App\Domain\Player\Player;
use App\Domain\Stadium\Stadium;
use App\Domain\Logo\Logo;

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

    /**
     * One club has one stadium
     * 
     * @ORM\OneToOne(targetEntity=Stadium::class, inversedBy="club", cascade={"persist"})
     * @ORM\JoinColumn(name="stadium_id", referencedColumnName="id", nullable=true)
     */
    private $stadium;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $palette;

    /**
     * One club has one logo
     * 
     * @ORM\OneToOne(targetEntity=Logo::class, inversedBy="club", cascade={"persist"})
     * @ORM\JoinColumn(name="logo", referencedColumnName="id", nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $youtube;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $slug;

    private function __construct(
        string $name,
        float $budget,
        Coach $coach,
        Stadium $stadium,
        string $slug,
        string $palette = null,
        string $facebook = null,
        string $twitter = null,
        string $youtube = null,
        string $instagram = null,
        string $website = null
    ) {
        $this->name     = $name;
        $this->budget   = $budget;
        $this->coach    = $coach;
        $this->stadium  = $stadium;
        $this->players  = new ArrayCollection();
        $this->slug     = $slug;
        $this->palette  = $palette;
        $this->facebook = $facebook;
        $this->twitter  = $twitter;
        $this->youtube  = $youtube;
        $this->instagram = $instagram;
        $this->website  = $website;
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

    public function getStadium(): ?Stadium
    {
        return $this->stadium;
    }

    private function setStadium(?Stadium $stadium): self
    {
        $this->stadium = $stadium;

        return $this;
    }

    public function getPalette(): ?string
    {
        return $this->palette;
    }

    private function setPalette(?string $palette): self
    {
        $this->palette = $palette;

        return $this;
    }

    public function getLogo(): ?Logo
    {
        return $this->logo;
    }

    private function setLogo(?Logo $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    private function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    private function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    private function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    private function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    private function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    private function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
        int $id = null,
        string $slug,
        string $name = '',
        float $budget = 0.0
    ): void {
        if (!empty($id) && $id < 0) {
            throw new InvalidClubIdException();
        }

        if (strlen($slug) <= 2) {
            throw new InvalidClubSlugException();
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
        Coach $coach,
        Stadium $stadium,
        string $slug,
        string $palette = null,
        string $facebook = null,
        string $twitter = null,
        string $youtube = null,
        string $instagram = null,
        string $website = null
    ): Club
    {

        /** Validate business model before anything else */
        self::validateBusinessModel(
            null,
            $slug,
            $name,
            $budget,
        );

        $club = new Club(
            $name,
            $budget,
            $coach,
            $stadium,
            $slug,
            $palette,
            $facebook,
            $twitter,
            $youtube,
            $instagram,
            $website
        );

        return $club;
    }

    public static function update(
        Club $club,
        string $name,
        float $budget,
        Coach $coach,
        Stadium $stadium,
        string $slug,
        string $palette = null,
        string $facebook = null,
        string $twitter = null,
        string $youtube = null,
        string $instagram = null,
        string $website = null
    ): void
    {

        /** Validate business model before anything else */
        self::validateBusinessModel(
            $club->getId(),
            $slug,
            $name,
            $budget,
        );

        $club->setName($name);
        $club->setBudget($budget);
        $club->setCoach($coach);
        $club->setStadium($stadium);
        $club->setSlug($slug);
        $club->setPalette($palette);
        $club->setFacebook($facebook);
        $club->setTwitter($twitter);
        $club->setYoutube($youtube);
        $club->setInstagram($instagram);
        $club->setWebsite($website);
    }

    public static function setCoachToNull(Club $club): void
    {
        $club->setCoach(null);
    }
}
