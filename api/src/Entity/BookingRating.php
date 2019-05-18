<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class BookingRating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking")
     *
     * @var Booking
     */
    private $booking;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FoodTruck",inversedBy="bookingRatings")
     *
     * @var FoodTruck
     */
    private $foodTruck;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer",inversedBy="bookingRatings")
     *
     * @var Customer
     */
    private $customer;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Assert\Range(
     *     min=Stars::MIN_VALUE,
     *     max=Stars::MAX_VALUE
     * )
     *
     * @var int
     */
    private $stars = Stars::MIN_VALUE;

    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    private $comment = '';

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
        $this->foodTruck = $booking->getFoodTruck();
    }

    public function getFoodTruck(): ?FoodTruck
    {
        return $this->foodTruck;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): void
    {
        if (Stars::MIN_VALUE > $stars || Stars::MAX_VALUE < $stars) {
            throw new \InvalidArgumentException(sprintf(
                'Value needs to be between (inclusive) %d and %d, but %d is not.',
                Stars::MIN_VALUE,
                Stars::MAX_VALUE,
                $stars
            ));
        }

        $this->stars = $stars;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
