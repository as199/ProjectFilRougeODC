<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="formateur")
     */
    public function index()
    {
        return $this->render('formateur/index.html.twig', [
            'controller_name' => 'FormateurController',
        ]);
    }

    /**
     * @Route("api/formateur/users", name="formateur_listes")
     */
    public function listeFormateurs(UserRepository $repo)
    {
        return $this->json($repo->findByProfil("FORMATEUR"), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }

    /**
     * @Route("api/formateur/users/{id}", name="liste_formateur")
     */
    public function listeFormateur(UserRepository $repo, Request $request)
    {
        $id = $request->get("id");
        $t = (int)$id;
        return $this->json($repo->findById($t), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }
    
}
