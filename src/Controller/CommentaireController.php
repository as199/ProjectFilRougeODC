<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    /**
     * @Route("users/promo/id/apprenant/id/chats", name="affiche_commentaire")
     */
    public function recuperationCommentaire(CommentaireRepository $repocom){
        $commentaires = $repocom->recupCommentaire();

        return $this->json($commentaires, Response::HTTP_OK, [],["groups"=>"commentaire:read"]);
    }

    /**
     * @Route("users/promo/apprenant/chats", name="add_commentaire")
     */
    public function addCommentaire(Request $request){

        $em = $this->getDoctrine()->getManager();
        $newDate = DateTime::createFromFormat("l dS F Y",'GMT');
        $newDate = $newDate->format('d/m/Y');
        $description = json_decode($request->getContent())->description;
        $createdAt = json_decode($request->getContent())->createdAt;
        /*$filDeDiscussion = json_decode($request->getContent())->filDeDiscussion;
        $formateurs = json_decode($request->getContent())->formateurs;*/
        $commentaires = new Commentaire();
        $commentaires->setDescription($description)
            ->setCreatedAt($newDate);
        $em->persist($commentaires);
        $em->flush();

        return new JsonResponse(sprintf('Commentaire %s successfully created', $commentaires->getCreatedAt()));
         }

}
