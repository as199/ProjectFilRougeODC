<?php

namespace App\Controller;

use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{

    /**
     * @Route("api/admin/promo/principal", name="admin_promo_principal")
     */
    public function admingroupeprincipal(GroupeRepository $repo, SerializerInterface $serializer)
    {
        return $this->json($repo->findByStatutGroupe("principal"), Response::HTTP_OK, [], ['groups' => 'admin_promo_principal:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }


    /**
     * @Route("api/admin/promo/{id}/principal", name="admin_promo_principal_id")
     */
    public function admingroupeprincipalid(GroupeRepository $repo, SerializerInterface $serializer, Request $request)
    {
        return $this->json($repo->findByStatutGroupeid("principal", (int)$request->get("id")), Response::HTTP_OK, [], ['groups' => 'admin_promo_principal:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }

    /**
     * @Route("api/admin/promo/{id1}/groupes/{id2}/apprenants", name="admin_promo_principal_apprenant")
     */
    public function adminpromogroupesid(PromoRepository $repo, SerializerInterface $serializer, Request $request)
    {
        return $this->json($repo->findByStatutGroupeidapprenant((int)$request->get("id1"), (int)$request->get("id2")), Response::HTTP_OK, [], ['groups' => 'admin_promo_principal:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }
}
