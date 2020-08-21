<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 * @ApiResource(attributes={"pagination_items_per_page"=2},
 *     itemOperations={
*             "get_grptags_id": {
 *             "method": "GET",
 *             "path": "/admin/grptags/{id}",
 *              "normalization_context"={"groups":"grptag:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource"
 *
 *         }
 *     ,"put_grptags_id": {
 *             "method": "PUT",
 *             "path": "/admin/grptags/{id}",
 *              "normalization_context"={"groups":"grptag:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource"
 *
 *         },
 *     "delete_grptags_id": {
 *             "method": "DELETE",
 *             "path": "/admin/grptags/{id}",
 *              "normalization_context"={"grptag":"formateur:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource"
 *
 *         }
 *     },
 *     collectionOperations={
*       "get_grpstags": {
 *             "method": "GET",
 *             "path": "/admin/grptags",
 *              "normalization_context"={"grptag":"formateur:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource"
 *
 *         },"post_grpstags": {
 *             "method": "POST",
 *             "path": "/admin/grptags",
 *              "normalization_context"={"groups":"grptag:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN')or is_granted('ROLE_FORMATEUR'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource"
 *
 *         }
 *     })
 */
class GroupeTag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"grptag:read"})
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupeTags")
     */
    private $tags;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grptag:read"})
     */
    private $libelle;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupeTag($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
            $tag->removeGroupeTag($this);
        }

        return $this;
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
}
