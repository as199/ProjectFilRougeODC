<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateurRepository;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource
 */
class Formateur extends User
{
}
