<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriverRepository::class)]
#[ApiResource]
class Driver extends User
{
    #[Groups(["read_bus", "write_bus"])]
    #[ORM\Column(type: 'string', length: 50)]
    private $driving_licence;

    #[ORM\OneToOne(mappedBy: 'driver', targetEntity: Bus::class, cascade: ['persist', 'remove'])]
    private $bus;

    public function getDrivingLicence(): ?string
    {
        return $this->driving_licence;
    }

    public function setDrivingLicence(string $driving_licence): self
    {
        $this->driving_licence = $driving_licence;

        return $this;
    }

    public function getBus(): ?Bus
    {
        return $this->bus;
    }

    public function setBus(?Bus $bus): self
    {
        // unset the owning side of the relation if necessary
        if ($bus === null && $this->bus !== null) {
            $this->bus->setDriver(null);
        }

        // set the owning side of the relation if necessary
        if ($bus !== null && $bus->getDriver() !== $this) {
            $bus->setDriver($this);
        }

        $this->bus = $bus;

        return $this;
    }
}
