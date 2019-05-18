<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Location
{
    /**
     * @var int The entity Id
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string A nice person
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $name = '';

    /**
     * @var string Latitude
     *
     * @ORM\Column(type="decimal",precision=8,scale=6)
     * @Assert\NotBlank
     */
    private $latitude = '';

    /**
     * @var string Longitude
     *
     * @ORM\Column(type="decimal",precision=9,scale=6)
     * @Assert\NotBlank
     */
    private $longitude = '';

    /**
     * @var string Food truck description
     *
     * @ORM\Column(type="text")
     */
    private $description = '';

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Slot",mappedBy="location")
     */
    private $slots;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CustomerLocation",mappedBy="location")
     */
    private $customerLocations;

    public function __construct()
    {
        $this->customerLocations = new ArrayCollection();
        $this->slots = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getSlots(): Collection
    {
        return $this->slots;
    }

    public function getCustomerLocations(): Collection
    {
        return $this->customerLocations;
    }
}
