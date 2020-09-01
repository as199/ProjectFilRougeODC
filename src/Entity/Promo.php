<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 * @ApiResource(
 * collectionOperations={
 *  "get":{
 *      "path":"admin/promo",
 *      "normalization_context"={"groups":"admin_promo:read"},
 *  },
 *  
 *  "post":{
 *      "path":"admin/promo",
 *  }
 * },
 * itemOperations={
 *  "get":{
 *      "path":"admin/promo/{id}",
 *      "normalization_context"={"groups":"admin_promo:read"},
 *   },
 *  "get1":{
 *      "method":"get",
 *      "path":"admin/promo/{id}/groupes",
 *      "normalization_context"={"groups":"admin_promo_groupe:read"},
 *  },
 * 
 *   "get2":{
 *      "method":"get",
 *      "path":"admin/promo/{id}/formateurs",
 *      "normalization_context"={"groups":"admin_promo_formateur:read"},
 *  },
 * "get3":{
 *      "method":"get",
 *      "path":"admin/promo/{id}/apprenants",
 *      "normalization_context"={"groups":"admin_promo_apprenant:read"},
 *  },
 *  "get4":{
 *      "method":"get",
 *      "path":"admin/promo/{id}/referentiels",
 *      "normalization_context"={"groups":"admin_promo_referenciel:read"},
 *  },
 *  
 *  "admin_promo_principal_apprenant":{
 *      "path":"api/admin/promo/{id}/groupes/{id}/apprenants",
 *      "normalization_context"={"groups":"admin_promo_principal:read"},
 *      
 *  },
 *  "put":{
 *      "path":"admin/promo/{id}",
 *  }
 * }
 
 * )
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
    * @Groups({"getbpa:read","admin_promo:read","admin_promo_formateur:read","admin_promo_referenciel:read","admin_promo_groupe:read","admin_groupe:read","admin_promo_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read","getbpa:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
    * @Groups({"getbpa:read","admin_promo:read","admin_promo_formateur:read","admin_promo_referenciel:read","admin_promo_groupe:read","admin_groupe:read","admin_promo_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read"})
     */
    private $nomPromotion;

    /**
     * @ORM\Column(type="date")
    * @Groups({"getbpa:read","admin_promo:read","admin_promo_formateur:read","admin_promo_referenciel:read","admin_promo_groupe:read","admin_groupe:read","admin_promo_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     *  @Groups({"getbpa:read","admin_promo:read","admin_promo_formateur:read","admin_promo_referenciel:read","admin_promo_groupe:read","admin_groupe:read","admin_promo_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read"})
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
    * @Groups({"admin_promo:read","admin_promo_formateur:read"})
     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promos",cascade={"persist"})
    * @Groups({"admin_promo:read","admin_promo_groupe:read","admin_promo_apprenant:read","admin_promo_principal:read"})
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Referenciel::class, mappedBy="promos")
    *  @Groups({"admin_promo:read","admin_promo_referenciel:read","admin_promo_attente:read"})
     */
    private $referenciels;

    /**
     * @ORM\OneToMany(targetEntity=CompetenceValides::class, mappedBy="promos")
     */
    private $competenceValides;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="promos", cascade={"persist"})
     * @Groups({"getbpa:read"})
     */
    private $briefMaPromos;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="promos")
     */
    private $chats;


    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->referenciels = new ArrayCollection();
        $this->competenceValides = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
        $this->chats = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPromotion(): ?string
    {
        return $this->nomPromotion;
    }

    public function setNomPromotion(string $nomPromotion): self
    {
        $this->nomPromotion = $nomPromotion;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->contains($formateur)) {
            $this->formateurs->removeElement($formateur);
        }

        return $this;
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
            $groupe->setPromos($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromos() === $this) {
                $groupe->setPromos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Referenciel[]
     */
    public function getReferenciels(): Collection
    {
        return $this->referenciels;
    }

    public function addReferenciel(Referenciel $referenciel): self
    {
        if (!$this->referenciels->contains($referenciel)) {
            $this->referenciels[] = $referenciel;
            $referenciel->addPromo($this);
        }

        return $this;
    }

    public function removeReferenciel(Referenciel $referenciel): self
    {
        if ($this->referenciels->contains($referenciel)) {
            $this->referenciels->removeElement($referenciel);
            $referenciel->removePromo($this);
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
            $competenceValide->setPromos($this);
        }

        return $this;
    }

    public function removeCompetenceValide(CompetenceValides $competenceValide): self
    {
        if ($this->competenceValides->contains($competenceValide)) {
            $this->competenceValides->removeElement($competenceValide);
            // set the owning side to null (unless already changed)
            if ($competenceValide->getPromos() === $this) {
                $competenceValide->setPromos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMaPromos(): Collection
    {
        return $this->briefMaPromos;
    }

    public function addBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if (!$this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos[] = $briefMaPromo;
            $briefMaPromo->setPromos($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos->removeElement($briefMaPromo);
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getPromos() === $this) {
                $briefMaPromo->setPromos(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
            $chat->setPromos($this);
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if ($this->chats->contains($chat)) {
            $this->chats->removeElement($chat);
            // set the owning side to null (unless already changed)
            if ($chat->getPromos() === $this) {
                $chat->setPromos(null);
            }
        }

        return $this;
    }




}



// *  "get":{
//     *      "path":"admin/promo/{id}/groupes/{id}/apprenants",
//     *      "name":"get_admin_promo_groupes_apprenants",
//     *      "normalization_context"={"groups":"admin_promo_groupe_app:read"}
//     *  },
