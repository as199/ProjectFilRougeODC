<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**

 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 * @ApiResource(
 *  collectionOperations={
 *      "get":{
 *          "path":"admin/groupes",
 *          "normalization_context"={"groups":"admin_groupe:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 *      "get1":{
 *          "method":"get",
 *          "path":"admin/groupes/apprenants",
 *          "normalization_context"={"groups":"admin_groupe_apprenant:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      
 *      },
 *      "admin_promo_principal":{
 *          "path":"admin/promo/principal",
 *          "normalization_context"={"groups":"admin_promo_principal:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 *      "post":{
 *          "path":"admin/groupes",
 *           "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *           "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      }
 *  },
 *  itemOperations={
 *      "get":{
 *          "path":"admin/groupes/{id}",
 *          "normalization_context"={"groups":"admin_groupe:read"}, 
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 *      "admin_promo_principal_id":{
 *      "path":"admin/promo/{id}/principal",
 *      "normalization_context"={"groups":"admin_promo_principal:read"},
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *      "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      
 *      },
 *      "put":{
 *          "path":"admin/groupes/{id}",
 *          "normalization_context"={"groups":"admin_groupe_id:read"},
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *      },
 *      "delete":{
 *          "path":"admin/groupes/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *          "access_control_message"="Vous n'avez pas access à cette Ressource",
 *          
 *      }
 *  }
 * )
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *@Groups({"admin_promo:read","admin_groupe:read","admin_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read","admin_promo_attente:read","formateur_brief:read","formateur_brief_p:read","admin_promo_groupes_apprenant:read","admin_promo_groupe:read","admin_groupe_id:read"})

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
    *@Groups({"admin_promo:read","admin_groupe:read","admin_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read","admin_promo_groupes_apprenant:read","admin_groupe_id:read"})

     */
    private $nomGroupe;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes")
    *@Groups({"admin_promo:read","admin_groupe:read","admin_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read","apprenant_brief:read","admin_promo_groupes_apprenant:read"})

     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     * @Groups({"admin_groupe:read","admin_promo_principal:read"})
     */
    private $formateurs;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes",cascade={"persist"})
     * @Groups({"admin_groupe:read","admin_promo_attente:read"})
     */
    private $promos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"admin_promo:read","admin_groupe:read","admin_groupe_apprenant:read","admin_promo_apprenant:read","admin_promo_principal:read","admin_promo_groupe:read"})
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="groupes")
     * Groups({"formateur_brief:read"})
     */
    private $etatBriefGroupes;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
        $this->etatBriefGroupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomGroupe(): ?string
    {
        return $this->nomGroupe;
    }

    public function setNomGroupe(string $nomGroupe): self
    {
        $this->nomGroupe = $nomGroupe;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
        }

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

    public function getPromos(): ?Promo
    {
        return $this->promos;
    }

    public function setPromos(?Promo $promos): self
    {
        $this->promos = $promos;

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
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatBriefGroupes(): Collection
    {
        return $this->etatBriefGroupes;
    }

    public function addEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if (!$this->etatBriefGroupes->contains($etatBriefGroupe)) {
            $this->etatBriefGroupes[] = $etatBriefGroupe;
            $etatBriefGroupe->setGroupes($this);
        }

        return $this;
    }

    public function removeEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if ($this->etatBriefGroupes->contains($etatBriefGroupe)) {
            $this->etatBriefGroupes->removeElement($etatBriefGroupe);
            // set the owning side to null (unless already changed)
            if ($etatBriefGroupe->getGroupes() === $this) {
                $etatBriefGroupe->setGroupes(null);
            }
        }

        return $this;
    }
}
