<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation as API;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 * @API\ApiFilter(SearchFilter::class, properties={"userName": "exact"})
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
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\CustomerLocation",mappedBy="customer")
     */
    private $customerLocations;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\BookingRating",mappedBy="customer")
     */
    private $bookingRatings;

    /**
     * @var Collection
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
     * @var Collection<Customer>
     */
    private $lunchTrains;

    public function __construct()
    {
        $this->lunchTrains = new ArrayCollection();
        $this->customerLocations = new ArrayCollection();
        $this->bookingRatings = new ArrayCollection();
        $this->favorites = new ArrayCollection();
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

    public function getCustomerLocations(): Collection
    {
        return $this->customerLocations;
    }

    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function getBookingRatings(): Collection
    {
        return $this->bookingRatings;
    }

    public function getLunchTrains(): Collection
    {
        return $this->lunchTrains;
    }

    public function setLunchTrains(Collection $lunchTrains): void
    {
        $this->lunchTrains = $lunchTrains;
    }
}
