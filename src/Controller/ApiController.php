<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\Formateur;
use App\Entity\Apprenant;
use App\Entity\Profil;
use App\Entity\User;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\ApprenantRepository;
use App\Repository\FormateurRepository;
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
     * @Route("api/admin/promo/apprenants/attente", name="admin_promo_apprenant_attente")
     */
    public function adminpromoapprenantattente(ApprenantRepository $repo, SerializerInterface $serializer)
    {
        return $this->json($repo->findByStatutGroupe("attente"), Response::HTTP_OK, [], ['groups' => 'admin_promo_attente:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }


    /**
     * @Route("api/admin/promo/{id}/apprenants/attente", name="admin_promo_apprenant_attente_id")
     */
    public function adminpromoapprenantattenteid(ApprenantRepository $repo, SerializerInterface $serializer, Request $request)
    {
        return $this->json($repo->findByStatutGroupeid("attente", (int)$request->get("id")), Response::HTTP_OK, [], ['groups' => 'admin_promo_attente:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }

    /**
     * @Route("api/admin/promo/{id1}/groupes/{id2}/apprenants", name="admin_promo_groupes_apprenant")
     */
    public function adminpromogroupesid(PromoRepository $repo, SerializerInterface $serializer, Request $request)
    {
        $promo = $repo->find((int)$request->get("id1"));
        if(isset($promo)){
          //  $result = [];
            $groupes = $promo->getGroupes();
            foreach($groupes as $groupe){
                if($groupe->getId() === (int)$request->get("id2")){
                    //$result = $groupe->getId();
                    return $this->json($groupe, Response::HTTP_OK, [], ['groups' => 'admin_promo_groupes_apprenant:read']);
                }
            }
        }
        // return $this->json($repo->findByStatutGroupeidapprenant((int)$request->get("id1"), (int)$request->get("id2")), Response::HTTP_OK, [], ['groups' => 'admin_promo_principal:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }

    /**
     * @Route("api/formateurs/promo/{id1}/groupe/{id2}/briefs", name="formateur_promo_groupe_brief")
     */
    public function formateurpromogroupebrief(PromoRepository $repo, SerializerInterface $serializer, Request $request)
    {
        $promo = $repo->find((int)$request->get("id1"));
        if($promo){
            foreach ($promo->getGroupes() as $groupe){
                if($groupe->getId() === (int)$request->get("id2")){
                    $gnomgroupe = $groupe->getNomGroupe();
                    $groupeformateurs = $groupe->getFormateurs();
                    $groupev = $groupe;
                    $etatbriefgrps = [];
                    foreach($groupe->getEtatBriefGroupes() as $etatbriefgrp){
                        $etatbriefgrps = $etatbriefgrp->getBriefs();
                        
                    }
                }
            }
            $result = [
                "promo" => $promo,
                "nomgroupe" => $gnomgroupe,
                "briefs" => $etatbriefgrps
            ];
            return $this->json($result, Response::HTTP_OK, [], ['groups' => 'formateur_brief_p:read']);
        }else{
                    return $this->json("le promo  ou le profil de sorti n'existe pas", Response::HTTP_BAD_REQUEST);
            }
        //return $this->json($repo->formateurpromogroupebrie((int)$request->get("id1"), (int)$request->get("id2")), Response::HTTP_OK, [], ['groups' => 'formateur_brief:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;

    //     public function getAppreantsByProfilSortiesInPromo(ProfilSortiRepository $repoPro, PromoRepository $promoRepository, $id, $num)
    // {
    //     $promo = $promoRepository->find($id);
    //     $profil = $repoPro->find($num);
    //     if($promo && $profil){
    //         $profilSorties = [];
    //         foreach ($promo->getGroupes() as $groupe) {
    //             foreach ($groupe->getApprenants() as $apprenant){
    //                 foreach ($apprenant->getProfilSortis() as $ps) {

    //                     if($ps->getId() == $num){$profilSorties = $profil;}
    //                 }
    //             }
    //         }

    //         return $this->json($profilSorties, 200);
    //     }else{
    //         return $this->json("le promo  ou le profil de sorti n'existe pas", Response::HTTP_BAD_REQUEST);
    //     }
    //  }
    }

    /**
     * @Route("api/formateurs/{id}/briefs/brouillons", name="formateur_brief_brouillon")
     */
    public function formateurbriefbrouillons(FormateurRepository $repo, SerializerInterface $serializer, Request $request)
    {
        $formateur = $repo->find((int)$request->get("id"));
        
        if($formateur->getProfil()->getLibelle() === "FORMATEUR"){
            $formateurbriefstab = [] ;
            foreach($formateur->getBriefs() as $formateurbriefs){
                
                if($formateurbriefs->getEtat() === "brouillon"){
                    $formateurbriefstab = $formateurbriefs;
                    
                }
            }
            return $this->json($formateurbriefstab, Response::HTTP_OK, [], ['groups' => 'formateur_brief_v:read']);
        }else{
            return $this->json("Ce n est pas un formateur");
        }
    }

    /**
     * @Route("api/formateurs/{id}/briefs/valide", name="formateur_brief_valide")
     */
    public function formateurbriefvalide(FormateurRepository $repo, SerializerInterface $serializer, Request $request)
    {

        $formateur = $repo->find((int)$request->get("id"));
        
        if($formateur->getProfil()->getLibelle() === "FORMATEUR"){
            $formateurbriefstab = [] ;
            foreach($formateur->getBriefs() as $formateurbriefs){
                
                if($formateurbriefs->getEtat() === "valide"){
                    $formateurbriefstab = $formateurbriefs;
                    
                }
            }
            return $this->json($formateurbriefstab, Response::HTTP_OK, [], ['groups' => 'formateur_brief_v:read']);
        }else{
            return $this->json("Ce n est pas un formateur");
        }
        
      
    }

    /**
     * @Route("api/formateurs/promo/{id1}/briefs/{id2}", name="formateur_promo_brief")
     */
    public function formateurpromobriefid(PromoRepository $repo, SerializerInterface $serializer, Request $request)
    {
        $promo = $repo->find((int)$request->get("id1"));
        
            $formateurbriefstab = [] ;
            foreach($promo->getBriefMaPromos() as $formateurbriefs){
                if($formateurbriefs->getBriefs()->getId() === (int)$request->get("id2")){
                    $formateurbriefstab = $formateurbriefs->getBriefs();
                }
                
            }
            
            //dd($formateurbriefstab);
            return $this->json($formateurbriefstab, Response::HTTP_OK, [], ['groups' => 'formateur_brief_promo:read']);
    }

    /**
     * @Route("api/formateur/promo/{id}/briefs", name="get5")
     */
    public function formateurpromobrief(PromoRepository $repo, SerializerInterface $serializer, Request $request)
    {
        $promo = $repo->find((int)$request->get("id"));
        
            $formateurbriefstab = [] ;
            foreach($promo->getBriefMaPromos() as $formateurbriefs){
                $formateurbriefstab = $formateurbriefs->getBriefs();
            }
            
            //dd($formateurbriefstab);
            return $this->json($formateurbriefstab, Response::HTTP_OK, [], ['groups' => 'formateur_brief_promo:read']);
        

        // return $this->json($repo->findByBriefidformateur((int)$request->get("id1"), (int)$request->get("id2")), Response::HTTP_OK, [], ['groups' => 'admin_promo_principal:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }


    /**
     * @Route("api/apprenant/promo/{id}/briefs", name="get6")
     */
    public function apprenantpromobrief(PromoRepository $repo, SerializerInterface $serializer, Request $request)
    {
        $promo = $repo->find((int)$request->get("id"));
        
            $formateurbriefstab = [] ;
            foreach($promo->getBriefMaPromos() as $formateurbriefs){
                $formateurbriefstab = $formateurbriefs->getBriefs();
            }
            
            //dd($formateurbriefstab);
            return $this->json($formateurbriefstab, Response::HTTP_OK, [], ['groups' => 'formateur_brief_promo:read']);
        

        // return $this->json($repo->findByBriefidformateur((int)$request->get("id1"), (int)$request->get("id2")), Response::HTTP_OK, [], ['groups' => 'admin_promo_principal:read']);
        //$this->bookPublishingHandler->handle($data);

        //return $data;
    }

    /**
     * @Route("api/admin/promo/{id}/referentiels", name="admin_promo_id_referentiel", methods="PUT")
     */
    public function adminpromoidreferentiel(PromoRepository $repo, SerializerInterface $serializer, Request $request){
        $requete =json_decode($request->getContent());
        $promo = $repo->find($request->get("id"));
        $promo->setNomPromotion($requete->nomPromotion);
        $em = $this->getDoctrine()->getManager();
        $em->persist($promo);
        //$referentiels = $promo->getReferentiels();
        foreach($promo->getReferenciels() as $ref){
            $ref->setLibelle($requete->libeller);
            $em->persist($ref);
        }
        
        $em->flush();

        return $this->json('modifie success');
        
    }

    /**
     * @Route("api/admin/promo/{id}/groupes/{id2}", name="put_admin_promo_groupes", methods="PUT")
     */
    public function putadminpromogroupes(PromoRepository $repo, SerializerInterface $serializer, Request $request){
        $requete =json_decode($request->getContent());
        $promo = $repo->find($request->get("id"));
       // $promo->setNomPromotion($requete->nomPromotion);
        $em = $this->getDoctrine()->getManager();
        
        foreach($promo->getGroupes() as $groupe){
            
            if($groupe->getId() === (int)$request->get("id2")){
                
                $groupe->setStatut($requete->statut);
                $em->persist($groupe);
                
            }
            
        }
        
        $em->flush();

        return $this->json('modifie success');
        
    }

    /**
     * @Route("api/admin/promo/{id}/formateurs", name="put_admin_promo_formateurs", methods="PUT")
     */
    public function putadminpromoformateurs(PromoRepository $repo, SerializerInterface $serializer, Request $request){
        $requete =json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();

        $promo = $repo->find($request->get("id"));
        
        if($requete->modif === 1){
            $formateur = new Formateur();
            $profil = $serializer->denormalize($requete->profil,User::class);
           $formateur->setProfil($profil)
                        ->setTelephone($requete->telephone)
                        ->setUsername($requete->username)
                        ->setEmail($requete->email)
                        ->setPrenom($requete->prenom)
                        ->setNom($requete->nom)
                        ->addPromo($promo)
                        ->setAdresse($requete->adresse);
                    $formateur->setPassword($requete->password);
                    //$promo->setFormateurs();
                    $em->persist($formateur);
                    $em->flush();
            return $this->json('ajout avec success');
        }
        if($requete->modif === 0){
            foreach($promo->getFormateurs() as $formateur){
                if($formateur->getId() === $requete->id){
                    $em->remove($formateur);
                    $em->flush();
                }
            }
            return $this->json('suppression avec success');
        }
    }

    /**
     * @Route("api/admin/promo/{id}/apprenants", name="put_admin_promo_apprenant", methods="PUT")
     */
    public function putadminpromoapprenants(PromoRepository $repo, SerializerInterface $serializer, Request $request){
        $requete =json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();

        $promo = $repo->find($request->get("id"));
        
        if($requete->modif === 1){
            $apprenant = new Apprenant();
            $profil = $serializer->denormalize($requete->profil,User::class);
           $apprenant->setProfil($profil)
                        ->setTelephone($requete->telephone)
                        ->setUsername($requete->username)
                        ->setEmail($requete->email)
                        ->setPrenom($requete->prenom)
                        ->setNom($requete->nom)
                        
                        ->setAdresse($requete->adresse);
                    $apprenant->setPassword($requete->password);
                    $groupe = $serializer->denormalize($requete->groupe,Apprenant::class);
                    
                        $apprenant->addGroupe($groupe);
                    
                    
                    foreach($apprenant->getGroupes() as $groupe){
                        $groupe->setPromos($promo);
                        
                    }
                    //$promo->se$apprenants();
                    $em->persist($apprenant);
                    $em->flush();
            return $this->json('ajout avec success');
        }
        if($requete->modif === 0){
            foreach($promo->getGroupes() as $groupe){
                
                foreach($groupe->getApprenants() as $apprenant){
                    
                    if($apprenant->getId() === $requete->id){
                        
                        $em->remove($apprenant);
                        $em->flush();
                    }
                }
                
            }
            return $this->json('suppression avec success');
        }
    }
}
