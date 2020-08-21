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
 *          "name":"get_admin_groupe",
 *          "normalization_context"={"groups":"admin_groupe:read"}
 *      },
 *      "get":{
 *          "path":"admin/groupes/apprenants",
 *          "name":"get_admin_groupe",
 *          "normalization_context"={"groups":"admin_groupe_app:read"}
 *      },
 *      "post":{
 *          "path":"admin/groupes",
 *          "name":"post_admin_groupe"
 *      },
 *  },
 *  itemOperations={
 *      "get":{
 *          "path":"admin/groupes/{id}",
 *          "name":"get_admin_groupe_id",
 *          "normalization_context"={"groups":"admin_groupe:read"}
 *      },
 *      "put":{
 *          "path":"admin/groupes/{id}",
 *          "name":"put_admin_groupe_id"
 *      },
 *      "delete":{
 *          "path":"admin/groupes/{id}/apprenants",
 *          "name":"delete_admin_groupe_id"
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
     * @Groups({"admin_promo_groupe:read","admin_promo_groupe_app:read","admin_groupe:read","admin_groupe_app:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin_promo_groupe:read","admin_promo_groupe_app:read","admin_groupe:read","admin_groupe_app:read"})
     */
    private $nomGroupe;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes")
     * @Groups({"admin_promo_groupe_app:read","admin_groupe_app:read"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     */
    private $formateurs;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes",cascade={"persist"})
     */
    private $promos;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
        $this->formateurs = new ArrayCollection();
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
}
