<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class FoodTruck
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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Booking",mappedBy="foodTruck")
     */
    private $bookings;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BookingRating",mappedBy="foodTruck")
     */
    private $bookingRatings;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite",mappedBy="foodTruck")
     */
    private $favorites;

    /**
     * @var string Food truck description
     *
     * @ORM\Column(type="text")
     */
    private $description = '';

    /**
     * @ORM\Column(options={"default": ""})
     *
     * @var string
     */
    private $imageUrl = '';

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->bookingRatings = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function getBookingRatings(): Collection
    {
        return $this->bookingRatings;
    }

    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }
}
