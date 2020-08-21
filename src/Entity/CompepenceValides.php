<?php

namespace App\Entity;

use App\Repository\CompepenceValidesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompepenceValidesRepository::class)
 */
class CompepenceValides
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau1(): ?string
    {
        return $this->niveau1;
    }

    public function setNiveau1(?string $niveau1): self
    {
        $this->niveau1 = $niveau1;

        return $this;
    }

    public function getNiveau2(): ?string
    {
        return $this->niveau2;
    }

    public function setNiveau2(?string $niveau2): self
    {
        $this->niveau2 = $niveau2;

        return $this;
    }

    public function getNiveau3(): ?string
    {
        return $this->niveau3;
    }

    public function setNiveau3(?string $niveau3): self
    {
        $this->niveau3 = $niveau3;

        return $this;
    }
}
