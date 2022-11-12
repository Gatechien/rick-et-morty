<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EpisodeRepository::class)
 */
class Episode
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
    private $air_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $episode;

    /**
     * @ORM\ManyToMany(targetEntity=Person::class, mappedBy="episode")
     */
    private $person;

    public function __construct()
    {
        $this->person = new ArrayCollection();
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

    public function getAirDate(): ?string
    {
        return $this->air_date;
    }

    public function setAirDate(string $air_date): self
    {
        $this->air_date = $air_date;

        return $this;
    }

    public function getEpisode(): ?string
    {
        return $this->episode;
    }

    public function setEpisode(string $episode): self
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * @return Collection<int, Person>
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->person->contains($person)) {
            $this->person[] = $person;
            $person->addEpisode($this);
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->person->removeElement($person)) {
            $person->removeEpisode($this);
        }

        return $this;
    }
}
