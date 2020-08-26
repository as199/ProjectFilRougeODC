<?php

namespace App\Controller;

use App\Entity\Chat;
use App\Repository\ApprenantRepository;
use App\Repository\ChatRepository;
use App\Repository\PromoRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ChatController extends AbstractController
{
    /**
     * @Route("users/promo/{id}/apprenant/{num}/chats", name="affiche_chat_apprenant", methods={"GET"})
     */
    public function recuperationCommentaire(ApprenantRepository $apprenantRepository,ChatRepository $repoChat,PromoRepository $promoRepository,$id,$num){
        $promo = $promoRepository->find($id);
        $apprenant = $apprenantRepository->find($num);
        if (!$promo || !$apprenant) {
            return $this->json("l'id du promo ou de l'apprenant  n'existe pas", Response::HTTP_BAD_REQUEST);
        }else{
            $chats[] = $repoChat->findChatsBy($id,$num);
            //dd($chats);
        }


        return $this->json($chats, Response::HTTP_OK, []);
    }
    /**
     * @Route("users/promo/{id}/apprenant/{num}/chats", name="add_chat",methods={"POST"})
     */
    public function addChat(Request $request,SerializerInterface $serializer,UserRepository $userRepository,PromoRepository $promoRepository,$id,$num){

        $donnes = json_decode($request->getContent(),true);

        $em = $this->getDoctrine()->getManager();
        if ($promoRepository->find($id)) {
            $user = $userRepository->find($num);
            if($user->getProfil()->getLibelle() == "APPRENANT"){
                $chat = $serializer->denormalize($donnes, Chat::class);

                $em->persist($chat);
                $em->flush();
                return new JsonResponse("success",Response::HTTP_CREATED,[],true);
            }else{
                return new JsonResponse("identifiant n'existe pas dans la promo");
            }
        }else{
            return new JsonResponse("la promo n'existe pas");
        }

    }
}
