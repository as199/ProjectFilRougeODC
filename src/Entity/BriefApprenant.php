<?php

namespace App\Entity;

use App\Repository\BriefApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BriefApprenantRepository::class)
 */
class BriefApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="briefApprenants")
     */
    private $apprenats;

    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="briefApprenants")
     */
    private $briefMaPromo;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="briefs")
     */
    private $briefApprenants;



    public function __construct()
    {
        $this->briefApprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getApprenats(): ?Apprenant
    {
        return $this->apprenats;
    }

    public function setApprenats(?Apprenant $apprenats): self
    {
        $this->apprenats = $apprenats;

        return $this;
    }

    public function getBriefMaPromo(): ?BriefMaPromo
    {
        return $this->briefMaPromo;
    }

    public function setBriefMaPromo(?BriefMaPromo $briefMaPromo): self
    {
        $this->briefMaPromo = $briefMaPromo;

        return $this;
    }


    /**
     * @return Collection|self[]
     */
    public function getBriefApprenants(): Collection
    {
        return $this->briefApprenants;
    }

    public function addBriefApprenant(self $briefApprenant): self
    {
        if (!$this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants[] = $briefApprenant;
            $briefApprenant->setBriefs($this);
        }

        return $this;
    }

    public function removeBriefApprenant(self $briefApprenant): self
    {
        if ($this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants->removeElement($briefApprenant);
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getBriefs() === $this) {
                $briefApprenant->setBriefs(null);
            }
        }

        return $this;
    }




}
