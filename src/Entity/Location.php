<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dimension;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="origin")
     */
    private $originPerson;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="location")
     */
    private $locationPerson;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDimension(): ?string
    {
        return $this->dimension;
    }

    public function setDimension(?string $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function getOriginPerson(): ?Person
    {
        return $this->originPerson;
    }

    public function setOriginPerson(?Person $originPerson): self
    {
        $this->originPerson = $originPerson;

        return $this;
    }

    public function getLocationPerson(): ?Person
    {
        return $this->locationPerson;
    }

    public function setLocationPerson(?Person $locationPerson): self
    {
        $this->locationPerson = $locationPerson;

        return $this;
    }
}
