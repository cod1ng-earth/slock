<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
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
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     */
    private $location;

    /**
     * @var Food truck
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\FoodTruck")
     */
    private $foodTruck;

    /**
     * @var Booking date
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $date;

    public function getId(): int
    {
        return $this->id;
    }
}
