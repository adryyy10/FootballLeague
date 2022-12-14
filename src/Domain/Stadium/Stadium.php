<?php

namespace App\Domain\Stadium;

use App\Domain\Club\Club;
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
}
