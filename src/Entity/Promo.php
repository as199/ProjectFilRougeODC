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
 *      "path":"admin/promo/",
 *      "name":"get_admin_promo",
 *      "normalization_context"={"groups":"admin_promo:read"}
 *  },
 *  "post":{
 *      "path":"admin/promo/",
 *      "name":"post_admin_promo"
 *  },
 *  
 * },
 * itemOperations={
 * "get":{
 *      "path":"admin/promo/{id}",
 *      "name":"get_admin_promo_id",
 *      "normalization_context"={"groups":"admin_promo:read"}
 *  },
 *  "get":{
 *      "path":"admin/promo/{id}/referentiels",
 *      "name":"get_admin_promo_id",
 *      "normalization_context"={"groups":"admin_promo_referentiel:read"}
 *  },
 *  "get":{
 *      "path":"admin/promo/{id}/formateurs",
 *      "name":"get_admin_promo_formateurs",
 *      "normalization_context"={"groups":"admin_promo_formateur:read"}
 *  },
 *  "get":{
 *      "path":"admin/promo/{id}/groupes",
 *      "name":"get_admin_promo_groupes",
 *      "normalization_context"={"groups":"admin_promo_groupe:read"}
 *  },
 *  "put":{
 *      "path":"admin/promo/{id}",
 *      "name":"post_admin_promo"
 *  },
 *  "put":{
 *      "path":"admin/promo/{id}/apprenants",
 *      "name":"post_admin_promo_app"
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

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $nomPromotion;

    /**
     * @ORM\Column(type="date")

     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)

    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")

     */
    private $formateurs;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promos",cascade={"persist"})

     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Referenciel::class, mappedBy="promos")

     */
    private $referenciels;


    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->referenciels = new ArrayCollection();

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




}



// *  "get":{
//     *      "path":"admin/promo/{id}/groupes/{id}/apprenants",
//     *      "name":"get_admin_promo_groupes_apprenants",
//     *      "normalization_context"={"groups":"admin_promo_groupe_app:read"}
//     *  },
