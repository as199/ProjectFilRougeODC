<?php

namespace App\Entity;

use App\Repository\CompetenceValidesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetenceValidesRepository::class)
 */
class CompetenceValides
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="competenceValides")
     */
    private $competences;

    /**
     * @ORM\ManyToOne(targetEntity=Referenciel::class, inversedBy="competenceValides")
     */
    private $referenciels;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="competenceValides")
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="competenceValides")
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
