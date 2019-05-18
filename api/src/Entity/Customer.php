<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Customer
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
     * @var string User name
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $userName = '';

    /**
     * @var string Password
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $password = '';

    /**
     * @ORM\Column(options={"default": ""})
     *
     * @var string
     */
    private $avatarUrl = '';

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CustomerLocation",mappedBy="customer")
     */
    private $customerLocations;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BookingRating",mappedBy="customer")
     */
    private $bookingRatings;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Favorite",mappedBy="customer")
     */
    private $favorites;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\LunchTrain",
     *     mappedBy="riders"
     * )
     * @ORM\JoinTable(name="lunch_train_riders")
     *
     * @var ArrayCollection<Customer>
     */
    private $lunchTrains;

    public function __construct()
    {
        $this->lunchTrains = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(string $avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
    }

    public function getCustomerLocations(): PersistentCollection
    {
        return $this->customerLocations;
    }

    public function getFavorites(): PersistentCollection
    {
        return $this->favorites;
    }

    public function getBookingRatings(): PersistentCollection
    {
        return $this->bookingRatings;
    }

    public function getLunchTrains(): ArrayCollection
    {
        return $this->lunchTrains;
    }

    public function setLunchTrains(ArrayCollection $lunchTrains): void
    {
        $this->lunchTrains = $lunchTrains;
    }
}
