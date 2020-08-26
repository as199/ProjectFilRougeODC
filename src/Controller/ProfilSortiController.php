<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\ProfilSorti;
use App\Repository\ApprenantRepository;
use App\Repository\GroupeRepository;
use App\Repository\ProfilSortiRepository;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ProfilSortiController extends AbstractController
{
    /**
     * @Route("api/admin/promo/{id}/profilsorties", name="affiche_apprenat_profil")
     */
    public function recupeApprenant(ProfilSortiRepository $repoPro, PromoRepository $promosRepository, GroupeRepository $repogroup, $id)
    {


        $promo = $promosRepository->findOneBy(["id" => $id]);
        if (!$promo)
            return $this->json("le promo  avec id $id n'existe pas", Response::HTTP_BAD_REQUEST);

        $groupes = $promo->getGroupes();
        //dd($groupe);
        $grpApprenant = [];
        foreach ($groupes as $groupe) {
            foreach ($groupe->getApprenants() as $apprenant) {
                if ($apprenant->getProfilSortis()) {
                    $grpApprenant[] = $apprenant->getProfilSortis();
                }
            }
        }
        return $this->json($grpApprenant, Response::HTTP_OK);

    }

    /**
     * @Route("api/admin/promo/{id}/profilsortie/{num}", name="get_apprenat_profil")
     */
    public function getAppreantsByProfilSortiesInPromo(ProfilSortiRepository $repoPro, PromoRepository $promoRepository, $id, $num)
    {
        $promo = $promoRepository->findOneBy(["id" => $id]);
        $profileSorti = $repoPro->findOneBy(["id" => $num]);
        if (!$promo || !$profileSorti) {
            return $this->json("l'id du promo ou du profilSortie  n'existe pas", Response::HTTP_BAD_REQUEST);
        }
        $gprApprenant = [];

        // recuperation des groupe du promo
        $groupes = $promo->getGroupes();
        // on parcoure les groupes
        foreach ($groupes as $groupe) {
            // $apprenants[] = $groupe->getApprenants();
            foreach ($groupe->getApprenants() as $apprenant) {
                if ($apprenant->getProfilSortis()) {
                    $por = $apprenant->getProfilSortis();
                    $part = $por[0]->getId();
                    if ($part === $profileSorti->getId())
                        $gprApprenant = $apprenant->getProfilSortis();
                }
            }
        }

        return $this->json($gprApprenant, Response::HTTP_OK);


    }
    /**
     * @Route("api/admin/profilsorties", name="add_profil_sorti",methods={"POST"})
     */
    public function addProfilSortie(SerializerInterface $serializer,ApprenantRepository $apprenantRepository,Request $request,ProfilSortiRepository $profilSortiRepository){
        $donnes = json_decode($request->getContent(),true);

            $em = $this->getDoctrine()->getManager();
            $profilsorti = $serializer->denormalize($donnes, ProfilSorti::class);

                $em->persist($profilsorti);
                $em->flush();
                return new JsonResponse("success",Response::HTTP_CREATED,[],true);


    }
}


