<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrableAttenduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrableAttenduRepository::class)
 * @ApiResource(
 * itemOperations={
 * },
 * collectionOperations={
 * "post_livrable_apprenant":{
 *   "method": "POST",
 *   "path": "/api/apprenants/{id}/groupe/{idg}/livrables",
 *   "normalization_context"={"groups":"postlivrables:read"},
 *   "access_control"="(is_granted('ROLE_APPRENANT'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"= "post_brief_promo_apprenant"
 *  },
 * })
 */
class LivrableAttendu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getbpf:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"postlivrables:read", "getbpf:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postlivrables:read", "getbpf:read"})
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="livrableAttendus", cascade={"persist"})
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=LivrableAttenduApprenant::class, mappedBy="livrableAttendus", cascade={"persist"})
     */
    private $livrableAttenduApprenants;

    public function __construct()
    {
        $this->briefs = new ArrayCollection();
        $this->livrableAttenduApprenants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
        }

        return $this;
    }

    /**
     * @return Collection|LivrableAttenduApprenant[]
     */
    public function getLivrableAttenduApprenants(): Collection
    {
        return $this->livrableAttenduApprenants;
    }

    public function addLivrableAttenduApprenant(LivrableAttenduApprenant $livrableAttenduApprenant): self
    {
        if (!$this->livrableAttenduApprenants->contains($livrableAttenduApprenant)) {
            $this->livrableAttenduApprenants[] = $livrableAttenduApprenant;
            $livrableAttenduApprenant->setLivrableAttendus($this);
        }

        return $this;
    }

    public function removeLivrableAttenduApprenant(LivrableAttenduApprenant $livrableAttenduApprenant): self
    {
        if ($this->livrableAttenduApprenants->contains($livrableAttenduApprenant)) {
            $this->livrableAttenduApprenants->removeElement($livrableAttenduApprenant);
            // set the owning side to null (unless already changed)
            if ($livrableAttenduApprenant->getLivrableAttendus() === $this) {
                $livrableAttenduApprenant->setLivrableAttendus(null);
            }
        }

        return $this;
    }
}
