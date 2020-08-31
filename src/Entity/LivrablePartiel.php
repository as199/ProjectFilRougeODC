<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 *  @ApiResource(
 * collectionOperations={
 *    "get_livrablepartiel1"={
 *     "method"="GET",
 *     "controller":"App\Controller\LivrablePartielController::class",
 *     "route_name"="recuperer_apprenants_referentiel",
 *     "normalizationContext"={"groups":{"livrablepartiel:read",}},
 *     "path"="/formateurs/promo/{id}/referentiel/{num}/competences",
 *     "access_control"="is_granted('ROLE_FORMATEUR')"
 *      },
 *     "get_livrablepartiel2"={
 *     "method"="GET",
 *     "normalizationContext"={"groups":{"livrablepartiel_stat:read",}},
 *     "path"="/formateurs/promo/{id}/referentiel/{id}/statistiques/competences",
 *     "controller":"App\Controller\LivrablePartielController::class",
 *     "route_name"="recuperer_stat_referentiel"
 *      "access_control"="is_granted('ROLE_FORMATEUR')"
 *      },
 *     "get_livrablepartiel3"={
 *     "method"="GET",
 *     "path"="/formateurs/livrablepartiels/{id}/commentaires",
 *     "controller":"App\Controller\LivrablePartielController::class",
 *     "route_name"="recuperer_les_commentaires",
 *     "access_control"="is_granted('ROLE_FORMATEUR')"
 *      },
 *     "post_livrablepartiel3"={
 *     "method"="POST",
 *     "normalizationContext"={"groups":{"livrablepartiel_comme:read"}},
 *     "path"="/formateurs/livrablepartiels/{id}/commentaires",
 *     "access_control"="is_granted('ROLE_FORMATEUR')"
 *      },
 *     "post_livrablepartiel4"={
 *     "method"="POST",
 *     "normalizationContext"={"groups":{"livrablepartiel_comme:read"}},
 *     "path"="/apprenants/livrablepartiels/{id}/commentaires",
 *     "access_control"="is_granted('ROLE_APPRENANT')"
 *      },
 *     "get_livrablepartiel4"={
 *     "method"="GET",
 *     "normalizationContext"={"groups":{"competenceV:read"}},
 *     "path"="/apprenant/{id}/promo/{id_a}/referentiel/{id_b}/competences",
 *     "controller":"App\Controller\LivrablePartielController::class",
 *     "route_name"="recuperer_appr_referentiel",
 *     "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))"
 *      },
 *     "get_apprenant_brief":{
 *     "route_name"="apprenant_stat_briefs",
 *     "path"="/api/apprenants/{id}/promo/{idp}/referentiel/{idr}/statistiques/briefs",
 *     "methods"={"GET"},
 *     "normalizationContext"={"groups":{"competenceV:read"}},
 *     "controller":"App\Controller\LivrablePartielController::class",
 *     "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *     },
 *
 *     },
 *     itemOperations={
 *      "get"={},
 *            "get_deux"={
 *          "method"="PUT",
 *          "path"="/api/apprenants/{id}/livrablepartiels/{id_d}",
 *          "route_name"="get_deux",
 *          "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))"
 *     },
 *     "get_deux_id"={
 *          "method"="PUT",
 *          "path"="/formateurs/promo/{id}/brief/{id_l}/livrablepartiels",
 *         "route_name"="get_deux_id",
 *         "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))"
 * },
 *     }
 *
 * )
 */
class LivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *  @Groups({ "livrablepartiel:read", "livrablepartiel_comme:read","livrablepartiel_appr:read","livrable_comm:read","livrable_comm:write","livrable_comm_discut:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({ "livrablepartiel:read","competences:read",})
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     *  @Groups({"livrablepartiel:read",})
     */
    private $delai;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read",})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"livrablepartiel:read",})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"livrablepartiel_appr:read",})
     */
    private $nombreRendu;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"livrablepartiel_comme:read",})
     */
    private $nombreCorriger;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="livrablePartiels")
     *
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="livrablePartiels")
     *  @Groups({"livrablepartiel:read",})
     */
    private $apprenantLivrablePartiels;

    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="livrablePartiels")
     *
     */
    private $briefMaPromos;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->apprenantLivrablePartiels = new ArrayCollection();
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

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->delai;
    }

    public function setDelai(\DateTimeInterface $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNombreRendu(): ?int
    {
        return $this->nombreRendu;
    }

    public function setNombreRendu(int $nombreRendu): self
    {
        $this->nombreRendu = $nombreRendu;

        return $this;
    }

    public function getNombreCorriger(): ?int
    {
        return $this->nombreCorriger;
    }

    public function setNombreCorriger(int $nombreCorriger): self
    {
        $this->nombreCorriger = $nombreCorriger;

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addLivrablePartiel($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeLivrablePartiel($this);
        }

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
            $apprenantLivrablePartiel->setLivrablePartiels($this);
        }

        return $this;
    }

    public function removeApprenantLivrablePartiel(ApprenantLivrablePartiel $apprenantLivrablePartiel): self
    {
        if ($this->apprenantLivrablePartiels->contains($apprenantLivrablePartiel)) {
            $this->apprenantLivrablePartiels->removeElement($apprenantLivrablePartiel);
            // set the owning side to null (unless already changed)
            if ($apprenantLivrablePartiel->getLivrablePartiels() === $this) {
                $apprenantLivrablePartiel->setLivrablePartiels(null);
            }
        }

        return $this;
    }

    public function getBriefMaPromos(): ?BriefMaPromo
    {
        return $this->briefMaPromos;
    }

    public function setBriefMaPromos(?BriefMaPromo $briefMaPromos): self
    {
        $this->briefMaPromos = $briefMaPromos;

        return $this;
    }

    public function setNbreRendue($nbreRendue)
    {
        return $this;
    }

    public function setNbreCorrige($nbreCorrige)
    {
        return $this;
    }
}
