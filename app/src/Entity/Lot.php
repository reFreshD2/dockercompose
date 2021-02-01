<?php

namespace App\Entity;

use App\Repository\LotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LotRepository::class)
 */
class Lot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Auction::class, inversedBy="lots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $auction;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lots")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\OneToOne(targetEntity=Bue::class, mappedBy="lot", cascade={"persist", "remove"})
     */
    private $bue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAuction(): ?Auction
    {
        return $this->auction;
    }

    public function setAuction(?Auction $auction): self
    {
        $this->auction = $auction;

        return $this;
    }

    public function getSeller(): ?User
    {
        return $this->seller;
    }

    public function setSeller(?User $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getBue(): ?Bue
    {
        return $this->bue;
    }

    public function setBue(Bue $bue): self
    {
        $this->bue = $bue;

        // set the owning side of the relation if necessary
        if ($bue->getLot() !== $this) {
            $bue->setLot($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName() . ' ' . $this->getPrice() . ' | ';
    }
}
