<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("api/admin/users", name="admin_listes")
     */
    public function listeAdmins(UserRepository $repo, SerializerInterface $serializer)
    {
        return $this->json($repo->findByProfil("ADMIN"), Response::HTTP_OK, [], ['groups' => 'admin:read']);
    }

    /**
     * @Route("api/admin/users/{id}", name="liste_admin")
     */
    public function listeAdmin(UserRepository $repo, Request $request)
    {
        return $this->json($repo->findById((int)$request->get("id")), Response::HTTP_OK, [], ['groups' => 'apprenant:read']);
    }
    /**
     * @Route("api/admin/users/del/{id}", name="supprimer_user")
     */
    public function deleteUser(User $user, Request $request, ManagerRegistry $manager)
    {
        if ($user->getId()) {
            $managers = $manager->getManager();
            $managers->remove($user);
            $managers->flush();
            if (!$user->getId()) {
                return $this->json([
                    'code' => 200,
                    'message' => 'supprimer avec succé'
                ]);
            }
        }
    }
    /**
     * @Route("api/register/users", name="ajouter_user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {

        // dd($request->getContent());
        $em = $this->getDoctrine()->getManager();

        $username = json_decode($request->getContent())->username;
        $password = json_decode($request->getContent())->password;
        $prenom = json_decode($request->getContent())->prenom;
        $nom = json_decode($request->getContent())->nom;
        $adresse = json_decode($request->getContent())->adresse;
        $telephone = json_decode($request->getContent())->telephone;
        $email = json_decode($request->getContent())->email;
        $user = new User();
        $user->setUsername($username)
            ->setPrenom($prenom)
            ->setNom($nom)
            ->setAdresse($adresse)
            ->setTelephone($telephone)
            ->setEmail($email);
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($encoder->encodePassword($user, $password));
        //dd($user);
        $em->persist($user);
        $em->flush();

        return new JsonResponse(sprintf('User %s successfully created', $user->getUsername()));
    }
}
