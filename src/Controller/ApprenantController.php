<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApprenantController extends AbstractController
{
    /**
     * @Route("api/apprenant/users", name="apprenant_listes")
     */
    public function listeApprenants(UserRepository $repo)
    {
        return $this->json($repo->findByProfil("APPRENANT"), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }

    /**
     * @Route("api/apprenant/users/{id}", name="liste_apprenant")
     */
    public function listeApprenant(UserRepository $repo, Request $request)
    {
        return $this->json($repo->findById((int)$request->get("id")), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }
}
