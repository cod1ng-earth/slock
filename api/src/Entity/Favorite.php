<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Favorite
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
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer",inversedBy="favorites")
     */
    private $customer;

    /**
     * @var FoodTruck
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\FoodTruck",inversedBy="favorites")
     */
    private $foodTruck;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    public function getFoodTruck(): FoodTruck
    {
        return $this->foodTruck;
    }

    public function setFoodTruck(FoodTruck $foodTruck): void
    {
        $this->foodTruck = $foodTruck;
    }
}
