<?php

namespace App\Entity;

use App\Repository\ApprenantLivrablePartielRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ApprenantLivrablePartielRepository::class)
 */
class ApprenantLivrablePartiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"livrablepartiel_comme:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="date")
     */
    private $delai;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablePartiel::class, inversedBy="apprenantLivrablePartiels")
     * @Groups({"livrablepartiel_comme:read"})
     */
    private $livrablePartiels;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="apprenantLivrablePartiels")
     * @Groups({"livrablepartiel_comme:read","competence:read"})
     */
    private $apprenants;

    /**
     * @ORM\OneToOne(targetEntity=FilDeDiscussion::class, cascade={"persist", "remove"})
     * @Groups({"livrablepartiel_comme:read"})
     */
    private $filDeDiscussions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

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

    public function getLivrablePartiels(): ?LivrablePartiel
    {
        return $this->livrablePartiels;
    }

    public function setLivrablePartiels(?LivrablePartiel $livrablePartiels): self
    {
        $this->livrablePartiels = $livrablePartiels;

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

    public function getFilDeDiscussions(): ?FilDeDiscussion
    {
        return $this->filDeDiscussions;
    }

    public function setFilDeDiscussions(?FilDeDiscussion $filDeDiscussions): self
    {
        $this->filDeDiscussions = $filDeDiscussions;

        return $this;
    }
}
