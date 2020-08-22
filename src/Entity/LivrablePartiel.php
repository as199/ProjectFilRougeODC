<?php

namespace App\Entity;

use App\Repository\LivrablePartielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivrablePartielRepository::class)
 */
class LivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date")
     */
    private $delai;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreRendu;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreCorriger;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="livrablePartiels")
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=ApprenantLivrablePartiel::class, mappedBy="livrablePartiels")
     */
    private $apprenantLivrablePartiels;

    /**
     * @ORM\ManyToOne(targetEntity=BriefMaPromo::class, inversedBy="livrablePartiels")
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
}
