<?php

namespace App\Entity;

use Doctrine\Common\Collections;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource
 * @ORM\Entity
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
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\LunchTrain",
     *     mappedBy="riders"
     * )
     * @ORM\JoinTable(name="lunch_train_riders")
     *
     * @var Collections\ArrayCollection<Customer>
     */
    private $lunchTrains;

    public function __construct()
    {
        $this->lunchTrains = new Collections\ArrayCollection();
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

    public function getLunchTrains(): Collections\ArrayCollection
    {
        return $this->lunchTrains;
    }

    public function setLunchTrains(Collections\ArrayCollection $lunchTrains): void
    {
        $this->lunchTrains = $lunchTrains;
    }
}
