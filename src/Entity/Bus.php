<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BusRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['read_bus']], denormalizationContext: ['groups' => ['write_bus']])]
class Bus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["read_bus", "write_bus"])]
    private $id;
    
    #[ORM\Column(type: 'string', length: 20)]
    #[Groups(["read_bus", "write_bus"])]
    private $immat;
    
    #[ORM\OneToOne(inversedBy: 'bus', targetEntity: Driver::class, cascade: ['persist', 'remove'])]
    #[Groups(["read_bus", "write_bus"])]
    private $driver;
    
    #[ORM\OneToMany(mappedBy: 'bus', targetEntity: Child::class)]
    #[Groups(["read_bus", "write_bus"])]
    private $childs;

    public function __construct()
    {
        $this->childs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImmat(): ?string
    {
        return $this->immat;
    }

    public function setImmat(string $immat): self
    {
        $this->immat = $immat;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Collection<int, Child>
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(Child $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setBus($this);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->childs->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getBus() === $this) {
                $child->setBus(null);
            }
        }

        return $this;
    }
}
