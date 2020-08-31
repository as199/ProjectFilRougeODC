<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ReferencielRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReferencielRepository", repositoryClass=ReferencielRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *     "get_referenciel"={
 *     "method"="GET",
 *     "normalizationContext"={"groups":{"referenciel:read","referenciel:read_all"}},
 *     "path"="/admin/referentiels",
 *      "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *     },
 *     "get_groupe_competence"={
 *     "method"="GET",
 *     "normalizationContext"={"groups":{"grcreferenciel:read","referenciel:read_all"}},
 *     "path"="/admin/referentiels/grpecompetences",
 *     "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *     },
 *     "post_referenciel"={
 *     "method"="POST",
 *     "path"="/admin/referentiels",
 *     "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))"
 *     },
 *     "post_groupe_competence"={
 *     "method"="POST",
 *     "denormalizationContext"={"groups":{"gecreferenciel:write"}},
 *     "path"="/admin/referentiels/grpecompetences",
 *     }
 *     },itemOperations={
 *     "GET"={
 *           "path":"/admin/referentiels/{id}",
 *     "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT')"
 *     },
 *     "GET"={
 *           "path":"/admin/referentiels/grpecompetences/{id}",
 *           "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT')"
 *     },
 *     "PUT"={
 *          "path":"/admin/referentiels/id/{id}",
 *          "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM') or is_granted('ROLE_APPRENANT')"
 *     }
 * }
 *
 *
 *
 * )
 */
class Referenciel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"referenciel:read", "gecreferenciel:write","grcreferenciel:read","admin_promo_referenciel:read"})

     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"referenciel:read","grcreferenciel:read","gecreferenciel:write","referenciel:read_all","apprenant:read","suprime:read","formateur:read","admin:read","admin_promo_referenciel:read"})

     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, inversedBy="referenciels")
     * 
     */
    private $promos;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="referentiels")
     * @Groups({"grcreferenciel:read",})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=CompetenceValides::class, mappedBy="referenciels")
     */
    private $competenceValides;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->groupeCompetences = new ArrayCollection();
        $this->competenceValides = new ArrayCollection();
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
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
        }

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addReferentiel($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeReferentiel($this);
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
            $competenceValide->setReferenciels($this);
        }

        return $this;
    }

    public function removeCompetenceValide(CompetenceValides $competenceValide): self
    {
        if ($this->competenceValides->contains($competenceValide)) {
            $this->competenceValides->removeElement($competenceValide);
            // set the owning side to null (unless already changed)
            if ($competenceValide->getReferenciels() === $this) {
                $competenceValide->setReferenciels(null);
            }
        }

        return $this;
    }
}
