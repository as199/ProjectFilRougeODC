<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(itemOperations={"PUT","DELETE","GET",
 *  "admin_promo_apprenant_attente_id":{
 *              "path":"admin/promo/apprenants/attente",
 *              "normalization_context"={"groups":"admin_promo_attente:read"}
 *         }
 * },
 * collectionOperations={"GET"={"path":"/admin/groups/apprenant",}
 * ,"POST",
 *  "admin_promo_apprenant_attente":{
 *              "path":"admin/promo/apprenants/attente",
 *              "normalization_context"={"groups":"admin_promo_attente:read"}
 *         }
 * }
 * )
 */
class Apprenant extends User
{
    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="apprenants")
     * @Groups({"admin_promo_attente:read",})
     */
    private $groupes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"admin_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read","admin_promo_attente:read"})
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="apprenants")
     * @Groups({"livrablepartiel_appr:read",})
     */
    private $apprenantLivrablePartiels;

    /**
     * @ORM\OneToMany(targetEntity=CompetenceValides::class, mappedBy="apprenants")
     * @Groups({"livrablepartiel:read",})
     */
    private $competenceValides;

    /**
     * @ORM\OneToMany(targetEntity=BriefApprenant::class, mappedBy="apprenats")
     */
    private $briefApprenants;

    public function __construct()
    {
        parent::__construct();
        $this->groupes = new ArrayCollection();
        $this->apprenantLivrablePartiels = new ArrayCollection();
        $this->competenceValides = new ArrayCollection();
        $this->briefApprenants = new ArrayCollection();
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            $groupe->removeApprenant($this);
        }

        return $this;
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

    /**
     * @return Collection|ApprenantLivrablePartiel[]
     */
    public function getApprenantLivrablePartiels(): Collection
    {
        return $this->apprenantLivrablePartiels;
    }

    public function addApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if (!$this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels[] = $apprenantLivrablePartiel;
            $apprenantLivrablePartiel->setApprenants($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if ($this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels->removeElement($apprenantLivrablePartiel);
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartiel->getApprenants() === $this) {
                $apprenantLivrablePartiel->setApprenants(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompetenceValides[]
     */
    public function getCompetenceValides(): Collection
    {
        return $this->competenceValides;
    }

    public function addCompetenceValide(CompetenceValides $competenceValide): self
    {
        if (!$this->competenceValides->contains($competenceValide)) {
            $this->competenceValides[] = $competenceValide;
            $competenceValide->setApprenants($this);
        }

        return $this;
    }

    public function removeCompetenceValide(CompetenceValides $competenceValide): self
    {
        if ($this->competenceValides->contains($competenceValide)) {
            $this->competenceValides->removeElement($competenceValide);
            // set the owning side to null (unless already changed)
            if ($competenceValide->getApprenants() === $this) {
                $competenceValide->setApprenants(null);
            }
        }

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
            $briefApprenant->setApprenats($this);
        }

        return $this;
    }

    public function removeBriefApprenant(BriefApprenant $briefApprenant): self
    {
        if ($this->briefApprenants->contains($briefApprenant)) {
            $this->briefApprenants->removeElement($briefApprenant);
            // set the owning side to null (unless already changed)
            if ($briefApprenant->getApprenats() === $this) {
                $briefApprenant->setApprenats(null);
            }
        }

        return $this;
    }
}
