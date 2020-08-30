<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EtatBriefGroupeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EtatBriefGroupeRepository::class)
 */
class EtatBriefGroupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * Groups({"formateur_brief:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="etatBriefGroupes")
     * Groups({"formateur_brief:read"})
     */
    private $briefs;

    /**
     * @ORM\ManyToOne(targetEntity=Groupe::class, inversedBy="etatBriefGroupes")
     */
    private $groupes;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBriefs(): ?Brief
    {
        return $this->briefs;
    }

    public function setBriefs(?Brief $briefs): self
    {
        $this->briefs = $briefs;

        return $this;
    }

    public function getGroupes(): ?Groupe
    {
        return $this->groupes;
    }

    public function setGroupes(?Groupe $groupes): self
    {
        $this->groupes = $groupes;

        return $this;
    }
}
