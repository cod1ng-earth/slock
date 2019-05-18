<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
     * @Assert\NotBlank()
     *
     * @var \DateTimeImmutable|null
     */
    private $leavesAt;

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

    public function getId($id): void
    {
        $this->id = $id;
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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
