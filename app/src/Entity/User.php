<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=Lot::class, mappedBy="seller", orphanRemoval=true)
     */
    private $lots;

    /**
     * @ORM\OneToMany(targetEntity=Bue::class, mappedBy="buyer", orphanRemoval=true)
     */
    private $bues;

    /**
     * @ORM\ManyToMany(targetEntity=Club::class, mappedBy="members")
     */
    private $clubs;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $security;

    public function __construct()
    {
        $this->lots = new ArrayCollection();
        $this->bues = new ArrayCollection();
        $this->clubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Lot[]
     */
    public function getLots(): Collection
    {
        return $this->lots;
    }

    public function addLot(Lot $lot): self
    {
        if (!$this->lots->contains($lot)) {
            $this->lots[] = $lot;
            $lot->setSeller($this);
        }

        return $this;
    }

    public function removeLot(Lot $lot): self
    {
        if ($this->lots->contains($lot)) {
            $this->lots->removeElement($lot);
            // set the owning side to null (unless already changed)
            if ($lot->getSeller() === $this) {
                $lot->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Bue[]
     */
    public function getBues(): Collection
    {
        return $this->bues;
    }

    public function addBue(Bue $bue): self
    {
        if (!$this->bues->contains($bue)) {
            $this->bues[] = $bue;
            $bue->setBuyer($this);
        }

        return $this;
    }

    public function removeBue(Bue $bue): self
    {
        if ($this->bues->contains($bue)) {
            $this->bues->removeElement($bue);
            // set the owning side to null (unless already changed)
            if ($bue->getBuyer() === $this) {
                $bue->setBuyer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Club[]
     */
    public function getClubs(): Collection
    {
        return $this->clubs;
    }

    public function addClub(Club $club): self
    {
        if (!$this->clubs->contains($club)) {
            $this->clubs[] = $club;
            $club->addMember($this);
        }

        return $this;
    }

    public function removeClub(Club $club): self
    {
        if ($this->clubs->contains($club)) {
            $this->clubs->removeElement($club);
            $club->removeMember($this);
        }

        return $this;
    }

    public function getSecurity(): ?string
    {
        return $this->security;
    }

    public function setSecurity(string $security): self
    {
        $this->security = $security;

        return $this;
    }

    public function __toString()
    {
        return $this->getLogin() . "   ";
    }
}
