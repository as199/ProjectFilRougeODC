<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 * @ApiResource (collectionOperations={
*           "GET":{
*               "method":"GET",
 *           "path":"users/promo/id/apprenant/id/chats",
 *             "controller": App\Controller\CommentaireController::class,
 *              "normalization_context"={"groups":"commentaire:read"},
 *             "route_name"="affiche_commentaire",
 *              }
 *     ,"POST":{
 *           "method":"POST",
*           "path":"users/promo/apprenant/ichats",
 *             "controller": App\Controller\CommentaireController::class,
 *              "normalization_context"={"groups":"addcommentaire:read"},
 *             "route_name"="add_commentaire",
 *     }
 *     },itemOperations={})
 */
class Chat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $piecesJointes;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="chats")
     */
    private $promos;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="chats")
     */
    private $user;

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
}
