<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CmController extends AbstractController
{
    /**
     * @Route("/cm", name="cm")
     */
    public function index()
    {
        return $this->render('cm/index.html.twig', [
            'controller_name' => 'CmController',
        ]);
    }
    /**
     * @Route("api/cm/users", name="cm_listes")
     */
    public function listeCms(UserRepository $repo)
    {
        return $this->json($repo->findByProfil("CM"), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }

    /**
     * @Route("api/cm/users/{id}", name="liste_cm")
     */
    public function listeCm(UserRepository $repo, Request $request)
    {
        $id = $request->get("id");
        $t = (int)$id;
        return $this->json($repo->findById($t), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }
    
}
