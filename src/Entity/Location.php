<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="origin")
     */
    private $originPerson;

    /**
     * @ORM\OneToMany(targetEntity=Person::class, mappedBy="location")
     */
    private $locationPerson;

    public function __construct()
    {
        $this->originPerson = new ArrayCollection();
        $this->locationPerson = new ArrayCollection();
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

    /**
     * @return Collection<int, Person>
     */
    public function getOriginPerson(): Collection
    {
        return $this->originPerson;
    }

    public function addOriginPerson(Person $originPerson): self
    {
        if (!$this->originPerson->contains($originPerson)) {
            $this->originPerson[] = $originPerson;
            $originPerson->setOrigin($this);
        }

        return $this;
    }

    public function removeOriginPerson(Person $originPerson): self
    {
        if ($this->originPerson->removeElement($originPerson)) {
            // set the owning side to null (unless already changed)
            if ($originPerson->getOrigin() === $this) {
                $originPerson->setOrigin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getLocationPerson(): Collection
    {
        return $this->locationPerson;
    }

    public function addLocationPerson(Person $locationPerson): self
    {
        if (!$this->locationPerson->contains($locationPerson)) {
            $this->locationPerson[] = $locationPerson;
            $locationPerson->setLocation($this);
        }

        return $this;
    }

    public function removeLocationPerson(Person $locationPerson): self
    {
        if ($this->locationPerson->removeElement($locationPerson)) {
            // set the owning side to null (unless already changed)
            if ($locationPerson->getLocation() === $this) {
                $locationPerson->setLocation(null);
            }
        }

        return $this;
    }
}
