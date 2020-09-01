<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivrableRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=LivrableRepository::class)
 * @ApiResource(
 * collectionOperations={
 * },
 * itemOperations={
 * 
 * }
 * )
 */
class Livrable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"postlivrables:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"postlivrables:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"postlivrables:read"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=BriefLivrable::class, mappedBy="livrables")
     */
    private $briefLivrables;

    public function __construct()
    {
        $this->briefLivrables = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|BriefLivrable[]
     */
    public function getBriefLivrables(): Collection
    {
        return $this->briefLivrables;
    }

    public function addBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if (!$this->briefLivrables->contains($briefLivrable)) {
            $this->briefLivrables[] = $briefLivrable;
            $briefLivrable->setLivrables($this);
        }

        return $this;
    }

    public function removeBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if ($this->briefLivrables->contains($briefLivrable)) {
            $this->briefLivrables->removeElement($briefLivrable);
            // set the owning side to null (unless already changed)
            if ($briefLivrable->getLivrables() === $this) {
                $briefLivrable->setLivrables(null);
            }
        }

        return $this;
    }
}
