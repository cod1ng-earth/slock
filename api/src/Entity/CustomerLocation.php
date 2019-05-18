<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Filter\LocationFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource
 * @ApiFilter(LocationFilter::class, properties={"location"}))
 * @ORM\Entity
 */
class CustomerLocation
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer",inversedBy="customerLocations")
     */
    private $customer;

    /**
     * @var Location
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location",inversedBy="customerLocations")
     */
    private $location;

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

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }
}
