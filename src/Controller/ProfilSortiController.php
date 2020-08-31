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
        $promo = $promoRepository->find($id);
        $profil = $repoPro->find($num);
        if($promo && $profil){
            $profilSorties = [];
            foreach ($promo->getGroupes() as $groupe) {
                foreach ($groupe->getApprenants() as $apprenant){
                    foreach ($apprenant->getProfilSortis() as $ps) {

                        if($ps->getId() == $num){$profilSorties = $profil;}
                    }
                }
            }

            return $this->json($profilSorties, 200);
        }else{
            return $this->json("le promo  ou le profil de sorti n'existe pas", Response::HTTP_BAD_REQUEST);
        }
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


