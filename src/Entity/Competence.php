<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiResource(
 * itemOperations={
 * "get_competence_id":{
 *   "method": "GET",
 *   "path": "/admin/competences/{id}",
 *   "normalization_context"={"groups":"competence:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * "update_competence_id":{
 *   "method": "PUT",
 *   "path": "/admin/competences/{id}",
 *   "normalization_context"={"groups":"competence:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 * },
 * },
 * collectionOperations={
 * "get_competences": {
 *   "method": "GET",
 *   "path": "/admin/competences",
 *   "normalization_context"={"groups":"competence:read"},
 *   "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *  },
 * "add_competence": {
 *    "method": "POST",
 *    "path": "/admin/competences",
 *    "normalization_context"={"groups":"competence:read"},
 *    "access_control"="(is_granted('ROLE_ADMIN'))",
 *    "access_control_message"="Vous n'avez pas access à cette Ressource",
 *    "route_name"="add_competence"
 *   }
 * }
 * )
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"competence:read", "gprecompetence:read", "gc:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"competence:read", "gprecompetence:read", "gc:read"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, inversedBy="competences", cascade={"persist"})
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="competences", cascade={"persist"})
     * @Groups({"competence:read"})
     */
    private $niveaux;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
        }

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
            $niveau->addCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeCompetence($this);
        }

        return $this;
    }
}
