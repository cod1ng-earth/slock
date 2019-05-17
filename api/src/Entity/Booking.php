<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This is a dummy entity. Remove it!
 *
 * @ApiResource
 * @ORM\Entity
 */
class Booking
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
     * @var Slot
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Slot")
     */
    private $slot;

    /**
     * @var FoodTruck truck
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\FoodTruck")
     */
    private $foodTruck;

    /**
     * @var DateTime booking date
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $date;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Slot
     */
    public function getSlot(): Slot
    {
        return $this->slot;
    }

    /**
     * @param Slot $slot
     */
    public function setSlot(Slot $slot): void
    {
        $this->slot = $slot;
    }

    /**
     * @return FoodTruck
     */
    public function getFoodTruck(): FoodTruck
    {
        return $this->foodTruck;
    }

    /**
     * @param FoodTruck $foodTruck
     */
    public function setFoodTruck(FoodTruck $foodTruck): void
    {
        $this->foodTruck = $foodTruck;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }
}
