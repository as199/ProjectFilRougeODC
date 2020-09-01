<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 * @ApiResource(
 * collectionOperations={
 *  "post_brief_formateur":{
 *   "method": "POST",
 *   "path": "/formateurs/briefs",
 *   "access_control"="(is_granted('ROLE_FORMATEUR'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="ajouter_brief"
 *  },
 * "dup_brief_promo_formateurs"={
 *   "method"= "POST",
 *   "path"= "api/formateurs/briefs/{id}",
 *   "access_control"="(is_granted('ROLE_FORMATEUR'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="dup_brief"
 *  },
 * },
 * itemOperations={
 * "get_brief_promo_formateurs"={
 *   "method"= "GET",
 *   "path"= "/api/formateurs/promo/{id}/brief/{idb}",
 *   "access_control"="(is_granted('ROLE_FORMATEUR'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="lister_briefs_formateur"
 *  
 * },
 * "get_brief_promo_apprenant"={
 *   "method"= "GET",
 *   "path"= "/apprenants/promos/{idp}/briefs/{idb}",
 *   "access_control"="(is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="afficher_brief_promo_apprenant"
 *  },
 *  "put_brief_promo_formateurs":{
 *   "method": "PUT",
 *   "path": "/formateurs/promo/{id}/brief/{idb}",
 *   "access_control"="(is_granted('ROLE_FORMATEUR'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="update_brief"
 *  },
 * "get_assignation_brief_promo_formateurs":{
 *   "method": "PUT",
 *   "path": "/formateurs/promo/{id}/brief/{idb}/assignation",
 *   "access_control"="(is_granted('ROLE_FORMATEUR'))",
 *   "access_control_message"="Vous n'avez pas access à cette Ressource",
 *   "route_name"="get_assignation_briefs_formateur"
 * },
 * }
 * )
 */
class Brief
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"postbrief:read", "getbpa:read", "putbpf:read", "getbpf:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"postbrief:read", "getbpa:read",  "putbpf:read", "getbpf:read"})
     */
    private $nomBrief;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read" })
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read"})
     */
    private $modalitePedagogique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read",})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", })
     */
    private $modaliteEvaluation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $imagePromo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read"})
     */
    private $archiver;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"postbrief:read", "getbpa:read", "getbpf:read"})
     */
    private $etat;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=BriefLivrable::class, mappedBy="briefs")
     */
    private $briefLivrables;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs")
     */
    private $formateurs;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, inversedBy="briefs")
     * @Groups({"getbpf:read"})
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=Ressource::class, mappedBy="briefs")
     * @Groups({"getbpf:read"})
     */
    private $ressources;

    /**
     * @ORM\OneToMany(targetEntity=BriefMaPromo::class, mappedBy="briefs", cascade={"persist"})
     */
    private $briefMaPromos;

    /**
     * @ORM\OneToMany(targetEntity=EtatBriefGroupe::class, mappedBy="briefs", cascade={"persist"})
     */
    private $etatBriefGroupes;

    /**
     * @ORM\ManyToMany(targetEntity=LivrableAttendu::class, mappedBy="briefs")
     * @Groups({"getbpf:read"})
     */
    private $livrableAttendus;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->briefLivrables = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
        $this->ressources = new ArrayCollection();
        $this->briefMaPromos = new ArrayCollection();
        $this->etatBriefGroupes = new ArrayCollection();
        $this->livrableAttendus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getNomBrief(): ?string
    {
        return $this->nomBrief;
    }

    public function setNomBrief(string $nomBrief): self
    {
        $this->nomBrief = $nomBrief;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(?string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalitePedagogique;
    }

    public function setModalitePedagogique(?string $modalitePedagogique): self
    {
        $this->modalitePedagogique = $modalitePedagogique;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(?string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getModaliteEvaluation(): ?string
    {
        return $this->modaliteEvaluation;
    }

    public function setModaliteEvaluation(?string $modaliteEvaluation): self
    {
        $this->modaliteEvaluation = $modaliteEvaluation;

        return $this;
    }

    public function getImagePromo()
    {
        return $this->imagePromo;
    }

    public function setImagePromo($imagePromo): self
    {
        $this->imagePromo = $imagePromo;

        return $this;
    }

    public function getArchiver(): ?string
    {
        return $this->archiver;
    }

    public function setArchiver(?string $archiver): self
    {
        $this->archiver = $archiver;

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTags(Tag $tags): self
    {
        if (!$this->tags->contains($tags)) {
            $this->tags[] = $tags;
        }

        return $this;
    }

    public function removeTag(Tag $tags): self
    {
        if ($this->tags->contains($tags)) {
            $this->tags->removeElement($tags);
        }

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
            $briefLivrable->setBriefs($this);
        }

        return $this;
    }

    public function removeBriefLivrable(BriefLivrable $briefLivrable): self
    {
        if ($this->briefLivrables->contains($briefLivrable)) {
            $this->briefLivrables->removeElement($briefLivrable);
            // set the owning side to null (unless already changed)
            if ($briefLivrable->getBriefs() === $this) {
                $briefLivrable->setBriefs(null);
            }
        }

        return $this;
    }

    public function getFormateurs(): ?Formateur
    {
        return $this->formateurs;
    }

    public function setFormateurs(?Formateur $formateurs): self
    {
        $this->formateurs = $formateurs;

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
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
        }

        return $this;
    }

    /**
     * @return Collection|Ressource[]
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setBriefs($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): self
    {
        if ($this->ressources->contains($ressource)) {
            $this->ressources->removeElement($ressource);
            // set the owning side to null (unless already changed)
            if ($ressource->getBriefs() === $this) {
                $ressource->setBriefs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BriefMaPromo[]
     */
    public function getBriefMaPromos(): Collection
    {
        return $this->briefMaPromos;
    }

    public function addBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if (!$this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos[] = $briefMaPromo;
            $briefMaPromo->setBriefs($this);
        }

        return $this;
    }

    public function removeBriefMaPromo(BriefMaPromo $briefMaPromo): self
    {
        if ($this->briefMaPromos->contains($briefMaPromo)) {
            $this->briefMaPromos->removeElement($briefMaPromo);
            // set the owning side to null (unless already changed)
            if ($briefMaPromo->getBriefs() === $this) {
                $briefMaPromo->setBriefs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EtatBriefGroupe[]
     */
    public function getEtatBriefGroupes(): Collection
    {
        return $this->etatBriefGroupes;
    }

    public function addEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if (!$this->etatBriefGroupes->contains($etatBriefGroupe)) {
            $this->etatBriefGroupes[] = $etatBriefGroupe;
            $etatBriefGroupe->setBriefs($this);
        }

        return $this;
    }

    public function removeEtatBriefGroupe(EtatBriefGroupe $etatBriefGroupe): self
    {
        if ($this->etatBriefGroupes->contains($etatBriefGroupe)) {
            $this->etatBriefGroupes->removeElement($etatBriefGroupe);
            // set the owning side to null (unless already changed)
            if ($etatBriefGroupe->getBriefs() === $this) {
                $etatBriefGroupe->setBriefs(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LivrableAttendu[]
     */
    public function getLivrableAttendus(): Collection
    {
        return $this->livrableAttendus;
    }

    public function addLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if (!$this->livrableAttendus->contains($livrableAttendu)) {
            $this->livrableAttendus[] = $livrableAttendu;
            $livrableAttendu->addBrief($this);
        }

        return $this;
    }

    public function removeLivrableAttendu(LivrableAttendu $livrableAttendu): self
    {
        if ($this->livrableAttendus->contains($livrableAttendu)) {
            $this->livrableAttendus->removeElement($livrableAttendu);
            $livrableAttendu->removeBrief($this);
        }

        return $this;
    }
}
