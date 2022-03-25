<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParentsRepository::class)]
#[ApiResource]
class Parents extends User
{
    #[Groups(["read_bus", "write_bus"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $phone;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Child::class)]
    private $childrens;

    public function __construct()
    {
        $this->childrens = new ArrayCollection();
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, Child>
     */
    public function getChildrens(): Collection
    {
        return $this->childrens;
    }

    public function addChildren(Child $children): self
    {
        if (!$this->childrens->contains($children)) {
            $this->childrens[] = $children;
            $children->setParent($this);
        }

        return $this;
    }

    public function removeChildren(Child $children): self
    {
        if ($this->childrens->removeElement($children)) {
            // set the owning side to null (unless already changed)
            if ($children->getParent() === $this) {
                $children->setParent(null);
            }
        }

        return $this;
    }
}
