<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Location
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
     * @var string A nice person
     *
     * @ORM\Column
     * @Assert\NotBlank
     */
    public $name = '';

    /**
     * @var string Latitude
     *
     * @ORM\Column(type="decimal",precision=8,scale=6)
     * @Assert\NotBlank
     */
    public $latitude = '';

    /**
     * @var string Longitude
     *
     * @ORM\Column(type="decimal",precision=9,scale=6)
     * @Assert\NotBlank
     */
    public $longitude = '';

    /**
     * @var string Food truck description
     *
     * @ORM\Column(type="text")
     */
    public $description = '';

    public function getId(): int
    {
        return $this->id;
    }
}
