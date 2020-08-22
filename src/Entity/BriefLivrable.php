<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefLivrableRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=BriefLivrableRepository::class)
 */
class BriefLivrable
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
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="briefLivrables")
     */
    private $briefs;

    /**
     * @ORM\ManyToOne(targetEntity=Livrable::class, inversedBy="briefLivrables")
     */
    private $livrables;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

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

    public function getLivrables(): ?Livrable
    {
        return $this->livrables;
    }

    public function setLivrables(?Livrable $livrables): self
    {
        $this->livrables = $livrables;

        return $this;
    }
}
