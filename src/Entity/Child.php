<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChildRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChildRepository::class)]
#[ApiResource]
class Child extends User
{
    #[ORM\Column(type: 'integer')]
    private $rates;
    #[Groups(["read_bus", "write_bus"])]
    #[ORM\ManyToOne(targetEntity: Parents::class, inversedBy: 'childrens')]
    private $parent;

    #[ORM\ManyToOne(targetEntity: Bus::class, inversedBy: 'childs')]
    private $bus;


    public function getRates(): ?int
    {
        return $this->rates;
    }

    public function setRates(int $rates): self
    {
        $this->rates = $rates;

        return $this;
    }

    public function getParent(): ?Parents
    {
        return $this->parent;
    }

    public function setParent(?Parents $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getBus(): ?Bus
    {
        return $this->bus;
    }

    public function setBus(?Bus $bus): self
    {
        $this->bus = $bus;

        return $this;
    }
}
