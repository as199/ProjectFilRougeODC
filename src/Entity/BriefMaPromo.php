<?php

namespace App\Entity;

use App\Repository\BriefMaPromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefMaPromoRepository::class)
 */
class BriefMaPromo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=LivrablePartiel::class, mappedBy="briefMaPromos")
     */
    private $livrablePartiels;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefMaPromos")
     */
    private $briefs;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="briefMaPromos")
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="briefMaPromo")
     */
    private $briefApprenants;



    public function __construct()
    {
        $this->livrablePartiels = new ArrayCollection();
        $this->briefApprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|LivrablePartiel[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->setBriefMaPromos($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablePartiel $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            // set the owning side to null (unless already changed)
            if ($livrablePartiel->getBriefMaPromos() === $this) {
                $livrablePartiel->setBriefMaPromos(null);
            }
        }

        return $this;
    }

    public function getBriefs(): ?Brief
    {
        return $this->briefs;
    }

    public function setBriefs(?Brief $briefs): self
    {
        $this->briefs = $briefs;

        return $this;
    }

    public function getPromos(): ?Promo
    {
        return $this->promos;
    }

    public function setPromos(?Promo $promos): self
    {
        $this->promos = $promos;

        return $this;
    }

    /**
     * @return Collection|BriefApprenant[]
     */
    public function getBriefApprenants(): Collection
    {
        return $this->briefApprenants;
    }

    public function addBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if (!$this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants[] = $briefApprenant;
            $briefApprenant->setBriefMaPromo($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants->removeElement($briefApprenant);
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getBriefMaPromo() === $this) {
                $briefApprenant->setBriefMaPromo(null);
            }
        }

        return $this;
    }


}
