<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     itemOperations={
 *         "get", "put", "delete",
 *         "add_rider": {
 *             "method": "POST",
 *             "path": "/lunch_trains/{id}/rider/{rider_id}",
 *             "controller": App\Controller\LunchTrainAddRider::class,
 *             "summary": "add a rider",
 *             "swagger_context": {
 *                 "summary": "add a rider to the lunch train",
 *                 "description": "add a rider"
 *             }
 *         }
 *     })
 *     @ApiFilter(DateFilter::class, properties={"leavesAt"})
 *     @ApiFilter(SearchFilter::class, properties={"booking"})
 *     @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Booking", inversedBy="lunchTrains")
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
     * @var Collection|Customer[]
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
        $this->riders = new ArrayCollection();
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
     * @return Collection|Customer[]
     */
    public function getRiders(): Collection
    {
        return $this->riders;
    }

    public function setRiders(Collection $riders): void
    {
        $this->riders = $riders;
    }

    public function addRider(Customer $customer): void
    {
        $this->riders->add($customer);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
