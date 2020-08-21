<?php

namespace App\Controller;

use App\Entity\GroupeCompetence;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GroupeCompetenceController extends AbstractController
{
    /**
     * @Route("api/admin/grpecompetences", 
     * name="ajout_groupe_competence", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerGroupeCompetenceController::ajout_groupe_competence",
     *      "_api_resource_class"=GroupeCompetence::class,
     *      "_api_collection_operation_name"="add_groupe_competence"
     *  }
     * )
     */
    public function ajout_groupe_competence(SerializerInterface $serializerInterface,Request $request,ValidatorInterface $validatorInterface)
    {
        $gpecompetenceJson = $request->getContent();
        $gpecompetences = $serializerInterface->deserialize($gpecompetenceJson,GroupeCompetence::class,'json');
        $competence = $gpecompetences->getCompetences();
        if(count($competence) == 0) {
            return $this->json("Veuillez ajouter au moins une compétence svp!");
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($gpecompetences);
        $entityManager->flush();

        return new JsonResponse("Groupe de compétence ajouté avec succès",Response::HTTP_CREATED,[],true);
    }
}
