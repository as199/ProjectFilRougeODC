<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\LivrableAttenduApprenantRepository;

/**
 * @ORM\Entity(repositoryClass=LivrableAttenduApprenantRepository::class)
 */
class LivrableAttenduApprenant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"postlivrables:read"})
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="livrableAttenduApprenants", cascade={"persist"})
     */
    private $apprenants;

    /**
     * @ORM\ManyToOne(targetEntity=LivrableAttendu::class, inversedBy="livrableAttenduApprenants", cascade={"persist"})
     * @Groups({"postlivrables:read"})
     */
    private $livrableAttendus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getLivrableAttendus(): ?LivrableAttendu
    {
        return $this->livrableAttendus;
    }

    public function setLivrableAttendus(?LivrableAttendu $livrableAttendus): self
    {
        $this->livrableAttendus = $livrableAttendus;

        return $this;
    }
}
