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
*           "path":"admin/profilsorties",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *     },
 * "GET":{
*           "method":"GET",
 *           "path":"admin/profilsorties",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *     }
 *     },
 * itemOperations={
 *     "GET1":{
 *          "method":"GET",
 *           "path":"admin/profilsorties/{id}",
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *     }, "GET2":{
 *          "method":"GET",
 *           "path":"admin/promo/{id}/profilsortie/{num}",
 *             "controller": App\Controller\ProfilSortiController::class,
 *           "normalization_context"={"groups":"admin_profilsortie:read"},
 *             "route_name"="affiche_apprenat_profil",
 *     },
 *     "PUT":{
 *           "path":"admin/profilsortie/id",
 *           "normalization_context"={"groups":"admin_id_profilsortie:read"},
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
     * @Groups({"groups":"admin_profilsortie:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groups":"admin_promo_attente:read","admin_profilsortie:read"})
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
    public function getUsers(): Collection
    {
        return $this->users;
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
