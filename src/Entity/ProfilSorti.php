<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilSortiRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProfilSortiRepository::class)
 * @ApiResource(
 * collectionOperations={"POST":{
*           "path":"api/admin/profilsorties",
 *             "controller": "App\Controller\ProfilSortiController::class",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *              "route_name"="add_profil_sorti",
 *     },
 *
 *     "GET3":{
 *          "method":"GET",
 *           "path":"api/admin/promo/{id}/profilsorties",
 *             "controller": "App\Controller\ProfilSortiController::class",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *             "route_name"="affiche_apprenat_profil",
 *     },
 * "GET":{
*
 *           "path":"admin/profilsorties",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *     }
 *     },
 * itemOperations={
 *     "GET1":{
 *          "method":"GET",
 *           "path":"admin/profilsorties/{id}",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *     },"GET2":{
 *          "method":"GET",
 *           "path":"api/admin/promo/{id}/profilsortie/{num}",
 *             "controller":" App\Controller\ProfilSortiController::class",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *             "route_name"="get_apprenat_profil",
 *     },
 *
 *     "PUT":{
 *           "path":"admin/profilsortie/{id}",
 *     }
 *  }
 * )
 */
class ProfilSorti
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groups":"admin_profilsortie:read","admin_id_profilsortie:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"admin_put_profilsortie:read","groups":"admin_promo_attente:read","admin_profilsortie:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="profilSortis")
     * @Groups({"admin_profilsortie:read"})
     */
    private $apprenants;


    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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

    public function removeUser(Apprenant $apprenant): self
    {
        if ($this->apprenants->contains($apprenant)) {
            $this->apprenants->removeElement($apprenant);
        }

        return $this;
    }



}
