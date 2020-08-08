<?php

namespace App\Controller;

use App\Repository\ProfilRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{

    /**
     * @Route("api/profils", name="liste_profils")
     */
    public function listeProfil(ProfilRepository $repo)
    {
        return $this->json($repo->findAll());
    }
}
