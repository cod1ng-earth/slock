<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
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
    public $name = '';

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Booking",mappedBy="foodTruck")
     */
    private $bookings;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BookingRating",mappedBy="foodTruck")
     */
    private $bookingRatings;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite",mappedBy="foodTruck")
     */
    private $favorites;

    /**
     * @var string Food truck description
     *
     * @ORM\Column(type="text")
     */
    public $description = '';

    /**
     * @ORM\Column(options={"default": ""})
     *
     * @var string
     */
    private $imageUrl = '';

    public function getId(): int
    {
        return $this->id;
    }

    public function getBookings(): PersistentCollection
    {
        return $this->bookings;
    }

    public function getBookingRatings(): PersistentCollection
    {
        return $this->bookingRatings;
    }

    public function getFavorites(): PersistentCollection
    {
        return $this->favorites;
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
