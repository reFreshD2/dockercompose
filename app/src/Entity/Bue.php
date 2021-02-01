<?php

namespace App\Entity;

use App\Repository\BueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BueRepository::class)
 */
class Bue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Lot::class, inversedBy="bue", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $lot;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="bues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLot(): ?Lot
    {
        return $this->lot;
    }

    public function setLot(Lot $lot): self
    {
        $this->lot = $lot;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }
}
