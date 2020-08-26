<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ApiResource (collectionOperations={
*           "POST":{
 *          "method":"POST",
*           "path":"users/promo/id/apprenant/id/chats",
 *             "controller":"App\Controller\ChatController::class",
 *              "normalization_context"={"groups":"addcommentaire:read"},
 *             "route_name"="add_chat",
 *     },
 *     "GET1":{
 *            "method":"GET",
 *           "path":"users/promo/id/apprenant/num/chats",
 *             "controller":"App\Controller\CommentaireController::class",
 *              "normalization_context"={"groups":"chat:read"},
 *             "route_name"="affiche_commentaire",
 *              }
 *     ,
 *     })
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups ({"chat:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups ({"chat:read"})
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups ({"chat:read"})
     */
    private $piecesJointes;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chats")
     * @Groups({"chat:read"})
     */
    private $promos;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chats")
     * @Groups({"chat:read"})
     */
    private $user;

    /**
     * @ORM\Column(type="date")
     * @Groups ({"chat:read"})
     */
    private $dateRedaction;

    /**
     * @ORM\Column(type="datetime")
     * @Groups ({"chat:read"})
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getPiecesJointes(): ?string
    {
        return $this->piecesJointes;
    }

    public function setPiecesJointes(?string $piecesJointes): self
    {
        $this->piecesJointes = $piecesJointes;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDateRedaction(): ?\DateTimeInterface
    {
        return $this->dateRedaction;
    }

    public function setDateRedaction(\DateTimeInterface $dateRedaction): self
    {
        $this->dateRedaction = $dateRedaction;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
