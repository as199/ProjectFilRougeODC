<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Repository\ApprenantRepository;
use App\Repository\GroupeRepository;
use App\Repository\ProfilSortiRepository;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilSortiController extends AbstractController
{
    /**
     * @Route("api/admin/promo/{id}/profilsortie/{num}", name="affiche_apprenat_profil")
     */
   public function recupeApprenant(ProfilSortiRepository $repoPro,PromoRepository $promoRepository,GroupeRepository $repogroup,$id,$num){
       $promo = $promoRepository->findOneBy(["id" => $id]);
       $profileSorti = $repoPro->findOneBy(["id" => $num]);
       if(!$promo || !$profileSorti)
           return $this->json("l'id du promo ou du profilSortie  n'existe pas", Response::HTTP_BAD_REQUEST);

       $groupes= $promo->getGroupes();
       $grpApprenant=[];
       foreach($groupes as $groupe)
       {
           $apprenants[] = $groupe->getApprenants();
           foreach($groupe->getApprenants() as $apprenant)
           {
               if($apprenant->getProfilSortis())
               {
                   $por = $apprenant->getProfilSortis();
                   $part = $por[0]->getId();
                   if($part===$profileSorti->getId())
                       $gprApprenant[]= $apprenant->getProfilSortis();
               }
           }
       }
       return $this->json($gprApprenant,Response::HTTP_OK);

    }
}
