<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class LunchTrain
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     *
     * @var Customer
     */
    private $operator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking")
     *
     * @var Booking
     */
    private $booking;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @Assert\NotBlank
     *
     * @var \DateTimeImmutable|null
     */
    private $leavesAt;

    /**
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Customer",
     *     inversedBy="lunchTrains"
     * )
     * @ORM\JoinTable(name="lunch_train_riders")
     *
     * @var Collections\Collection<Customer>
     */
    private $riders;

    /**
     * @ORM\Column(type="datetime_immutable")
     *
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function __construct()
    {
        $this->riders = new Collections\ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOperator(): Customer
    {
        return $this->operator;
    }

    public function setOperator(Customer $operator): void
    {
        $this->operator = $operator;
    }

    public function getBooking(): ?Booking
    {
        return $this->booking;
    }

    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
    }

    public function getLeavesAt(): ?\DateTimeImmutable
    {
        return $this->leavesAt;
    }

    public function setLeavesAt(\DateTimeImmutable $leavesAt): void
    {
        $this->leavesAt = $leavesAt;
    }

    /**
     * @return Collections\Collection<Customer>
     */
    public function getRiders(): Collections\Collection
    {
        return $this->riders;
    }

    public function setRiders(Collections\Collection $riders): void
    {
        $this->riders = $riders;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
