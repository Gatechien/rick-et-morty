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
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="origin")
     */
    private $originCharacter;

    /**
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="location")
     */
    private $locationCharacter;

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

    public function getOriginCharacter(): ?Character
    {
        return $this->originCharacter;
    }

    public function setOriginCharacter(?Character $originCharacter): self
    {
        $this->originCharacter = $originCharacter;

        return $this;
    }

    public function getLocationCharacter(): ?Character
    {
        return $this->locationCharacter;
    }

    public function setLocationCharacter(?Character $locationCharacter): self
    {
        $this->locationCharacter = $locationCharacter;

        return $this;
    }
}
