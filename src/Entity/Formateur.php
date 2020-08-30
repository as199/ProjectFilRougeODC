<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "get"
 *  },
 *  itemOperations={
 *      "get",
 *      
 *      
 *      "formateur_brief_brouillon":{
 *          "path":"formateurs/{id}/briefs/brouillons",
 *          "normalization_context"={"groups":"formateur_brief:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') )",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          
 *      },
 *      "formateur_brief_valide":{
 *          "path":"formateurs/{id}/briefs/valide",
 *          "normalization_context"={"groups":"formateur_brief_v:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') )",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          
 *      },
 *      
 *  }
 * )
 */
class Formateur extends User
{
    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="formateurs")
     * Groups({"formateurpromogroupebrief:read"})
     * 
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="formateurs")
     */
    private $promos;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="formateurs")
     * Groups({"formateur_brief_v:read"})
     
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="formateurs")
     */
    private $commentaires;

    public function __construct()
    {
        parent::__construct();
        $this->groupes = new ArrayCollection();
        $this->promos = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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
            $groupe->addFormateur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->contains($groupe)) {
            $this->groupes->removeElement($groupe);
            $groupe->removeFormateur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addFormateur($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            $promo->removeFormateur($this);
        }

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
            $brief->setFormateurs($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            // set the owning side to null (unless already changed)
            if ($brief->getFormateurs() === $this) {
                $brief->setFormateurs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setFormateurs($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFormateurs() === $this) {
                $commentaire->setFormateurs(null);
            }
        }

        return $this;
    }
}
