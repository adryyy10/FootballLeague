<?php

namespace App\Domain\Stadium;

use App\Domain\Club\Club;
use App\Domain\Exceptions\Stadium\InvalidStadiumAddressException;
use App\Domain\Exceptions\Stadium\InvalidStadiumBuiltException;
use App\Domain\Exceptions\Stadium\InvalidStadiumCapacityException;
use App\Domain\Exceptions\Stadium\InvalidStadiumIdException;
use App\Domain\Exceptions\Stadium\InvalidStadiumNameException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StadiumRepository::class)
 */
class Stadium
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
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $built;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * One stadium has one club
     * 
     * @ORM\OneToOne(targetEntity=Club::class, mappedBy="stadium", cascade={"persist"})
     */
    public $club;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $img;

    public function __construct(
        int $id = null,
        string $name,
        int $capacity,
        int $built,
        string $address
    ) {
        $this->id       = $id;
        $this->name     = $name;
        $this->capacity = $capacity;
        $this->built    = $built;
        $this->address  = $address;
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getBuilt(): ?int
    {
        return $this->built;
    }

    public function setBuilt(int $built): self
    {
        $this->built = $built;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public static function validateBusinessModel(
        int $id = null,
        string $name,
        int $capacity,
        int $built,
        string $address
    ): void {
        
        if (!empty($id) && $id < 0) {
            throw new InvalidStadiumIdException();
        }

        if (strlen($name) < 2) {
            throw new InvalidStadiumNameException();
        }

        if ($capacity < 0) {
            throw new InvalidStadiumCapacityException();
        }

        if ($built < 0) {
            throw new InvalidStadiumBuiltException();
        }

        if (strlen($address) < 2) {
            throw new InvalidStadiumAddressException();
        }
    }

    public static function create (
        string $name,
        int $capacity,
        int $built,
        string $address
    ): self {

        /** Validate business logic */
        self::validateBusinessModel(null, $name, $capacity, $built, $address);

        return new self (
            null,
            $name,
            $capacity,
            $built,
            $address
        );
    }
}
