<?php

namespace App\Controller;

use App\Entity\Competence;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{
    /**
     * @Route(
     * "api/admin/competences", 
     * name="add_competence", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerCompetenceController::ajout_competence",
     *      "_api_resource_class"=Competence::class,
     *      "_api_collection_operation_name"="add_competence"
     *  }
     * )
     */
    public function ajout_competence(SerializerInterface $serializerInterface,Request $request)
    {
        $competenceJson = $request->getContent();
        $competences = $serializerInterface->deserialize($competenceJson,Competence::class,'json');
        $niveau = $competences->getNiveaux();
        if(count($niveau) == 0) {
            return $this->json("Veuillez ajouter au moins un niveau de compétence svp!");
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($competences);
        $entityManager->flush();

        return new JsonResponse("Compétence ajoutée avec succès",Response::HTTP_CREATED,[],true);
    }
}
