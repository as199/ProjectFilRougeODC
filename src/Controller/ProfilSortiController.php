<?php

namespace App\Controller;

use App\Entity\Apprenant;
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
       //$groups =$promoRepository->recupGroup($id);
    $nompromo = $repogroup->recupApprenant($id);
    //dd($nompromo[0]);
       //$nompromo = $repogroup->recupApprenant($id);
    $taille=(count($nompromo));

       return $this->json($nompromo[1], Response::HTTP_OK, [],["groups"=>"admin_profilsortie:read"]);
   }
}
