<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceValidesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CompetenceValidesRepository::class)
 * @ApiResource ()
 */
class CompetenceValides
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *  @Groups ({"livrablepartiel:read","livrablepartiel_stat:read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="competenceValides")
     *  @Groups ({"livrablepartiel:read","livrablepartiel_stat:read",})
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Referenciel::class, inversedBy="competenceValides")
     * @Groups({"livrablepartiel_stat:read",})
     *
     */
    private $referenciels;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competenceValides")
     *  @Groups ({"competence:read","livrablepartiel:read","livrablepartiel_stat:read"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="competenceValides")
     * @Groups({"competenceV:read"})
     */
    private $promos;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompetences(): ?Competence
    {
        return $this->competences;
    }

    public function setCompetences(?Competence $competences): self
    {
        $this->competences = $competences;

        return $this;
    }

    public function getReferenciels(): ?Referenciel
    {
        return $this->referenciels;
    }

    public function setReferenciels(?Referenciel $referenciels): self
    {
        $this->referenciels = $referenciels;

        return $this;
    }

    public function getApprenants(): ?Apprenant
    {
        return $this->apprenants;
    }

    public function setApprenants(?Apprenant $apprenants): self
    {
        $this->apprenants = $apprenants;

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
