<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_id", type="integer")
 * @ORM\DiscriminatorMap({1="Admin",2="Formateur", 3="Cm", 4="Apprenant", "user"="User"})
 * @ApiResource(
 *  itemOperations={"PUT","DELETE",
 * "get_admin_id": {
 *             "method": "GET",
 *             "path": "/admin/users/{id}",
 *              "normalization_context"={"groups":"admin:read"},
 *             "controller": App\Controller\AdminController::class,
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="liste_admin"
 *         },
 * "get_formateur_id": {
 *             "method": "GET",
 *             "path": "/formateur/users/{id}",
 *              "normalization_context"={"groups":"formateur:read"},
 *             "controller": App\Controller\AdminController::class,
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              
 *         },
 * 
 * "get_apprenant_id": {
 *             "method": "GET",
 *             "path": "/formateur/users/{id}",
 *              "normalization_context"={"groups":"apprenant:read"},
 *             "controller": App\Controller\AdminController::class,
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="liste_apprenant"
 *         },
 
 * 
 * "get_cm_id": {
 *             "method": "GET",
 *             "path": "/cm/users/{id}",
 *              "normalization_context"={"groups":"cm:read"},
 *             "controller": App\Controller\AdminController::class,
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="liste_cm"
 *         }
 * },
 *     collectionOperations={"GET",
 * "add_user": {
 *             "method": "POST",
 *             "path": "/register/users",
 *             "controller": App\Controller\AdminController::class,
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="ajouter_user"
 *         },
 * "get_admins": {
 *             "method": "GET",
 *             "path": "/admin/users",
 *             "controller": App\Controller\AdminController::class,
 *              "normalization_context"={"groups":"admin:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="admin_listes"
 *         },
 * "get_apprenant": {
 *             "method": "GET",
 *             "path": "/apprenant/users",
 *             "controller": App\Controller\AdminController::class,
 *              "normalization_context"={"groups":"apprenant:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="apprenant_listes"
 *         }
 * ,
 * "get_formateur": {
 *             "method": "GET",
 *             "path": "/formateur/users",
 *             "controller": App\Controller\AdminController::class,
 *              "normalization_context"={"groups":"formateur:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="formateur_listes"
 *         },
 * "get_cm": {
 *             "method": "GET",
 *             "path": "/cm/users",
 *             "controller": App\Controller\AdminController::class,
 *              "normalization_context"={"groups":"formateur:read"},
 *              "access_control"="(is_granted('ROLE_ADMIN'))",
 *              "access_control_message"="Vous n'avez pas access à cette Ressource",
 *              "route_name"="cm_listes"
 *         }
 * }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"apprenant:read"})
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $username;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"apprenant:read","formateur:read","admin:read","cm:read"})
     */
    private $profil;

    /**
     * @ORM\ManyToMany(targetEntity=ProfilSorti::class, mappedBy="users")
     */
    private $profilSortis;

    public function __construct()
    {
        $this->profilSortis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * @return Collection|ProfilSorti[]
     */
    public function getProfilSortis(): Collection
    {
        return $this->profilSortis;
    }

    public function addProfilSorti(ProfilSorti $profilSorti): self
    {
        if (!$this->profilSortis->contains($profilSorti)) {
            $this->profilSortis[] = $profilSorti;
            $profilSorti->addUser($this);
        }

        return $this;
    }

    public function removeProfilSorti(ProfilSorti $profilSorti): self
    {
        if ($this->profilSortis->contains($profilSorti)) {
            $this->profilSortis->removeElement($profilSorti);
            $profilSorti->removeUser($this);
        }

        return $this;
    }
}
