<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Brief;
use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Niveau;
use App\Entity\Livrable;
use App\Entity\Apprenant;
use App\Entity\Ressource;
use App\Entity\Competence;
use App\Entity\BriefMaPromo;
use App\Entity\BriefApprenant;
use App\Entity\EtatBriefGroupe;
use App\Entity\LivrableAttendu;
use Symfony\Component\Mime\Email;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\ApprenantRepository;
use App\Entity\LivrableAttenduApprenant;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BriefMaPromoRepository;
use App\Repository\BriefApprenantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\BrowserKit\Request as BrowserKitRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BriefController extends AbstractController
{
    /**
     * @Route(
     * "api/formateurs/briefs", 
     * name="ajouter_brief", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::add_brief_par_formateurs",
     *      "_api_resource_class"=Brief::class,
     *      "_api_collection_operation_name"="post_brief_formateur"
     *  }
     * )
     */
    public function add_brief_par_formateurs(TokenStorageInterface $tokenStorage, BriefRepository $briefRepository, SerializerInterface $serializerInterface, Request $request, EntityManagerInterface $entityManager)
    {   
        $briefJson = json_decode($request->getContent());
        $briefDup= new Brief();
        $formateur = $tokenStorage->getToken()->getUser();
            $briefDup
                ->setFormateurs(($formateur))
                ->setNomBrief($briefJson->nomBrief)
                ->setCreatedAt(new \DateTime())
                ;
        
        $em = $this->getDoctrine()->getManager();
        for ($i=0; $i<count($briefJson->niveaux); $i++) {
            $briefDup->addNiveau($em->getRepository(Niveau::class)->find($briefJson->niveaux[$i]->id));
        }
        for ($i=0; $i<count($briefJson->livrableAttendus); $i++) {
            $briefDup->addLivrableAttendu($em->getRepository(LivrableAttendu::class)->find($briefJson->livrableAttendus[$i]->id));
        }
        for ($i=0; $i<count($briefJson->tags); $i++) {
            $briefDup->addTags($em->getRepository(Tag::class)->find($briefJson->tags[$i]->id));
        }
        for ($i=0; $i<count($briefJson->ressources); $i++) {
            $briefDup->addRessource($em->getRepository(Ressource::class)->find($briefJson->ressources[$i]->id));
        }
        
        $entityManager->persist($briefDup);
        $entityManager->flush();     

        return $this->json("Brief ajouté avec succès");
        

    }

    /**
     * @Route(
     * "/api/apprenants/{id}/groupe/{idg}/livrables", 
     * name="post_brief_promo_apprenant",
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::ajouter_livrable_promo_apprenants",
     *      "_api_resource_class"=LivrableAttendu::class,
     *      "_api_collection_operation_name"="post_livrable_apprenant"
     *  }
     * )
     */
    public function ajouter_livrable_promo_apprenants(int $id,int $idg,SerializerInterface $serializerInterface, GroupeRepository $groupeRepo, Request $request, EntityManagerInterface $manager)
    {
        $groupe = $groupeRepo->findOneBy(["id"=>$idg]);
        
        $livrable = json_decode($request->getContent(), true);
        if(!empty($groupe)){
            
            foreach ($groupe->getApprenants() as $apprenant) {
                if($apprenant->getId() == $id){
                    foreach ($groupe->getApprenants() as $apprenant) {   
                    $em = $this->getDoctrine()->getManager();
                   $repository = $em->getRepository(LivrableAttendu::class);
                   $livAtt= $repository->findBy(array(), array('id' => 'desc'),1,0);

                    if (isset($livrable['url'])){
                        foreach ($livrable['url'] as $key =>$url){
                            $livrableAttenduApprenant = new LivrableAttenduApprenant();
                            $livrableAttenduApprenant->setUrl($url)
                                                    ->setApprenants($apprenant)
                                                    ->setLivrableAttendus($livAtt[0])
                            ;
                            $manager->persist($livrableAttenduApprenant);
                        }
                    }    
                }
            }

            }
            $manager->flush();
            return $this->json("Livrable attendu ajouté avec succes pour les apprenants de ce groupe");
        }
        
    }

    /**
     * @Route(
     * "api/formateurs/promo/{id}/brief/{idb}/assignation", 
     * name="get_assignation_briefs_formateur", 
     * methods={"PUT"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::assignation_brief_promo_formateurs",
     *      "_api_resource_class"=Brief::class,
     *      "_api_item_operation_name"="get_assignation_brief_promo_formateurs"
     *  }
     * )
     */
    public function assignation_brief_promo_formateurs(int $id, int $idb,MailerInterface $mailer, PromoRepository $promoRepository, BriefRepository $briefRepository, SerializerInterface $serializerInterface, EntityManagerInterface $entityManagerInterface, Request $request)
    {
        $promo = $promoRepository->find($id);
        if(!empty($promo)){
            $briefData = json_decode($request->getContent(), true);
            $briefMaPromos = $promo->getBriefMaPromos();
            $brief = $briefRepository->find($idb);
            if (!empty($brief)) {
                foreach ($briefMaPromos as  $briefMaPromo) { 
                    if($briefMaPromo->getBriefs()->getId() == $idb){
                        $getBriefs = $briefMaPromo->getBriefs();
                        if (isset($briefData['apprenants'])){
                            for ($i=0; $i<count($briefData['apprenants']); $i++){ 
                                $apprenant = $serializerInterface->denormalize($briefData['apprenants'][$i], User::class);
                                $briefApprenant = new BriefApprenant();
                                $briefApprenant->setBriefMaPromo($briefMaPromo);
                                $briefApprenant->setApprenats($apprenant);
                                $briefApprenant->setStatut("assigné"); 
                                $entityManagerInterface->persist($briefApprenant);
                            }  
                            /* $appEmail = $apprenant->getEmail();
                            $email = (new Email())
                                        ->from('amysow04@gmail.com') 
                                        ->to('amy.sow1@uadb.edu.sn') 
                                        ->subject('Assignation') 
                                        ->text('Vous avez été assigné assigné à un brief. Veuillez-vous mettre au boulot. Il n\'y aura un changement de délai')
                            ;

                            $mailer->send($email); */
                        }

                        else if (isset($briefData['apprenantDes'])){
                                
                                for ($i=0; $i<count($briefData['apprenantDes']); $i++){
                                        $idApprenant= explode("/",$briefData['apprenantDes'][$i]);
                                        $id=(int)$idApprenant[count($idApprenant)-1];
                                        $repository = $this->getDoctrine()->getRepository(BriefApprenant::class);
                                        $apprenants = $repository->findOneBy(["apprenats"=> $id, "briefMaPromo"=>$briefMaPromo->getId()]);
                                        
                                        if(!$apprenants){
                                            return new JsonResponse("L'apprenant dont l'id='" . $id . "n'existe pas", Response::HTTP_BAD_REQUEST, [], true);
                                        }
                                        else{
                                            if($apprenants->getStatut() == 'assigné'){
                                                $apprenants->setStatut("desassigné");
                                            }
                                            else{
                                                return new JsonResponse("L'apprenant dont l'id='" . $id . "n'est pas assigné à ce brief", Response::HTTP_BAD_REQUEST, [], true);
                                            }
                                        }
                                } 
                        } 

                        else if(isset($briefData['groupes'])){
                            for ($i=0; $i<count($briefData['groupes']); $i++){
                                $etatBrief = new EtatBriefGroupe();
                                $briefMaPromoG = new BriefMaPromo();
                                $groupe = $serializerInterface->denormalize($briefData['groupes'][$i], Groupe::class);
                                $etatBrief->setGroupes($groupe);
                                $etatBrief->setStatut('En cours');
                                $etatBrief->setBriefs($getBriefs);
                                $getBriefs->addEtatBriefGroupe($etatBrief);
                                $briefMaPromoG->setPromos($promo);
                                $briefMaPromoG->setBriefs($getBriefs);
                                $getBriefs->addBriefMaPromo($briefMaPromoG);

                                $entityManagerInterface->persist($etatBrief);
                                $entityManagerInterface->persist($briefMaPromoG);
                            }     
                        }

                        else if(isset($briefData['groupesDes'])){
                            for ($i=0; $i<count($briefData['groupesDes']); $i++){
                
                                $idEtatBriefGroupe= explode("/",$briefData['groupesDes'][$i]);
                                $id=(int)$idEtatBriefGroupe[count($idEtatBriefGroupe)-1];
                                $repository = $this->getDoctrine()->getRepository(EtatBriefGroupe::class);
                                $briefEtatGroupes = $repository->findOneBy(["groupes"=> $id, "briefs"=>$getBriefs->getId()]);
                                
                                if(!$briefEtatGroupes){
                                    return new JsonResponse("Le groupe dont l'id='" . $id . "n'existe pas ou n'est pas assigné à ce brief", Response::HTTP_BAD_REQUEST, [], true);
                                }
                                else{
                                    if($briefEtatGroupes->getStatut() == 'assigné'){
                                        $briefEtatGroupes->setStatut("desassigné");
                                    }
                                    else{
                                        return new JsonResponse("L'apprenant dont l'id='" . $id . "n'est pas assigné à ce brief", Response::HTTP_BAD_REQUEST, [], true);
                                    }
                                }
                                $entityManagerInterface->persist($briefEtatGroupes);
                            }    
                        }

                        $entityManagerInterface->flush();
                        return $this->json("Brief assigné ou desassigné à l'apprenant avec succès");
                    }


                }
            }
        }
           
    }

    /**
     * @Route(
     * "/api/formateurs/promo/{id}/brief/{idb}", 
     * name="lister_briefs_formateur", 
     * methods={"GET"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::lister_brief_promo_formateurs",
     *      "_api_resource_class"=Brief::class,
     *      "_api_item_operation_name"="get_brief_promo_formateurs"
     *  }
     * )
     */
    public function lister_brief_promo_formateurs(int $id, int $idb, PromoRepository $promoRepository,BriefRepository $briefRepository, SerializerInterface $serializerInterface, Request $request)
    {
       $promo = $promoRepository->findOneBy(["id"=>$id]);
       if (!empty($promo)){
            $briefMaPromos = $promo->getBriefMaPromos();
            foreach ($briefMaPromos as $briefMaPromo) { 
                if($briefMaPromo->getBriefs()->getId()  == $idb){
                    $brief = $briefRepository->findOneBy(["id"=>$idb]);
                    return $this->json($brief, 200,[], ["groups"=>"getbpf:read"]);
                }
            }
         
       }

      
    }

    /**
     * @Route(
     * "/api/apprenants/promos/{id}/briefs/{idb}", 
     * name="afficher_brief_promo_apprenant", 
     * methods={"GET"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::lister_brief_promo_apprenants",
     *      "_api_resource_class"=Brief::class,
     *      "_api_collection_operation_name"="get_brief_promo_apprenant"
     *  }
     * )
     */
    public function lister_brief_promo_apprenants(int $id, int $idb,BriefRepository $briefRepository, PromoRepository $promoRepository)
    {
        $promo = $promoRepository->findOneBy(["id"=>$id]);
       if (!empty($promo)){
            $briefMaPromos = $promo->getBriefMaPromos();
            foreach ($briefMaPromos as $briefMaPromo) { 
                if($briefMaPromo->getBriefs()->getId()  == $idb){
                    $brief = $briefRepository->findOneBy(["id"=>$idb]);
                    $briefApprenants = $briefMaPromo->getBriefs();

                    foreach ($briefApprenants as $briefApprenant) {
                            $apprenants =  $briefApprenant->getApprenats();
                            foreach ($apprenants as $apprenant) {
                                dd("ok");
                                return $this->json($brief, 200,[], ["groups"=>"getbpa:read"]);  
                            }
                    
                    }
                    
                }
            }
         
       }
         
    }

    /**
     * @Route(
     * "api/formateurs/promo/{id}/brief/{idb}", 
     * name="update_brief", 
     * methods={"PUT"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::update_brief_par_formateurs",
     *      "_api_resource_class"=Brief::class,
     *      "_api_item_operation_name"="put_brief_promo_formateurs"
     *  }
     * )
     */
    public function update_brief_par_formateurs(int $id, int $idb, EntityManagerInterface $manager, PromoRepository $promoRepository, BriefRepository $briefRepository, Request $request, SerializerInterface $serializerInterface)
    {   
        $promo = $promoRepository->findOneBy(["id"=>$id]);
        $em = $this->getDoctrine()->getManager();
       
        if(!empty($promo)){ 
            $briefMaPromos = $promo->getBriefMaPromos();
            foreach ($briefMaPromos as $briefMaPromo) {
                if (($briefMaPromo->getBriefs()->getId() == $idb) and ($briefMaPromo->getPromos()->getId() == $id)) {
                    $brief = $briefRepository->findOneBy(["id"=>$idb]);
                    $briefTab = json_decode($request->getContent(), true);
                    if ((isset($briefTab['briefDelete'])) and ($briefTab['briefDelete'][0] == "oui") ) { 
                        if ($brief->getArchiver() == "non" or $brief->getArchiver() == null) {
                            $brief->setArchiver("oui");
                            $manager->flush();
                            return $this->json("Ce brief a ete archive avec succes");
                        } 
                        else if ($brief->getArchiver() == "oui"){
                            return $this->json("Ce brief a deja ete archive");
                        }
                    }

                    if ((isset($briefTab['cloturer'])) and ($briefTab['cloturer'][0] == "oui") ) { 
                        if ($brief->getEtat() != "archiver" or $brief->getEtat() == null) {
                            $brief->setEtat("archiver");
                            $manager->flush();
                            return $this->json("Ce brief a ete archive avec succes");
                        } 
                        else if ($brief->getEtat() == "archiver"){
                            return $this->json("Ce brief a deja ete cloture");
                        }
                    }


                    if (isset($briefTab['niveauxAdd'])) { 
                        for ($i=0; $i<count($briefTab['niveauxAdd']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['niveauxAdd'][$i], Brief::class);
                            $brief->addNiveau($em->getRepository(Niveau::class)->find($briefData));
                        }
                        $manager->flush();
                        return $this->json("Niveau ajoute au brief avec succes");
                    }

                    if (isset($briefTab['niveauxDel'])) { 

                        for ($i=0; $i<count($briefTab['niveauxDel']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['niveauxDel'][$i], Brief::class);
                            $brief->removeNiveau($em->getRepository(Niveau::class)->find($briefData));
                        }
                        $manager->flush();
                        return $this->json("Niveau supprimé au niveau de ce brief avec succes");
                    }
                    
                    if (isset($briefTab['livrableAttendusAdd'])) {
                        for ($i=0; $i<count($briefTab['livrableAttendusAdd']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['livrableAttendusAdd'][$i], Brief::class);
                            $brief->addLivrableAttendu($em->getRepository(LivrableAttendu::class)->find($briefData));
                            
                        }
                        $manager->flush();
                        return $this->json("livrable Attendu ajoute au brief avec succes");
                    }

                    if (isset($briefTab['livrableAttendusDel'])) {
                        for ($i=0; $i<count($briefTab['livrableAttendusDel']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['livrableAttendusDel'][$i], Brief::class);
                            $brief->removeLivrableAttendu($em->getRepository(LivrableAttendu::class)->find($briefData));
                            
                        }
                        $manager->flush();
                        return $this->json("livrable Attendu supprime du brief avec succes");
                    }

                    if (isset($briefTab['tagsAdd'])) {
                        for ($i=0; $i<count($briefTab['tagsAdd']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['tagsAdd'][$i], Brief::class);
                            $brief->addTags($em->getRepository(Tag::class)->find($briefData));
                        }
                        $manager->flush();
                        return $this->json("Tag ajoute avec succes au brief avec succes");
                    }

                    if (isset($briefTab['tagsDel'])) {
                        for ($i=0; $i<count($briefTab['tagsDel']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['tagsDel'][$i], Brief::class);
                            $brief->removeTag($em->getRepository(Tag::class)->find($briefData));
                            
                        }
                        $manager->flush();
                        return $this->json("Tag supprime du brief avec succes");
                    }

                    if (isset($briefTab['ressourcesAdd'])) {
                        for ($i=0; $i<count($briefTab['ressourcesAdd']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['ressourcesAdd'][$i], Brief::class);
                            $brief->addRessource($em->getRepository(Ressource::class)->find($briefData));
                            
                        }
                        $manager->flush();
                        return $this->json("Ressource ajoute au brief avec succes");
                    }

                    if (isset($briefTab['ressourcesDel'])) {
                        for ($i=0; $i<count($briefTab['ressourcesDel']); $i++) {
                            $briefData = $serializerInterface->denormalize($briefTab['ressourcesDel'][$i], Brief::class);
                            $brief->removeRessource($em->getRepository(Ressource::class)->find($briefData));
                            
                        }
                        $manager->flush();
                        return $this->json("Cette ressource n'est plus associé a ce brief");
                    }
                    
                }
                
            }
            $manager->flush();
            return $this->json("Operation non reusie!");
        }
        return $this->json("Impossible de faire un traitement!");

    }

    /**
     * @Route(
     * "/api/formateur/briefs/{id}",
     * name="dup_brief", 
     * methods={"POST"},
     * defaults={
     *      "_controller"="\app\ControllerBriefController::duplication_brief_par_formateurs",
     *      "_api_resource_class"=Brief::class,
     *      "_api_collection_operation_name"="dup_brief_promo_formateurs"
     *  }
     * )
     */
    public function duplication_brief_par_formateurs(TokenStorageInterface $tokenStorage, BriefRepository $briefRepository, $id, EntityManagerInterface $entityManagerInterface)
    {
        $brief = $briefRepository->find($id);
        if ($brief) {
            $formateur = $tokenStorage->getToken()->getUser();
            $briefDup= new Brief();
            $briefDup
                ->setFormateurs(($formateur))
                ->setNomBrief($brief->getNomBrief())
                ->setDescription($brief->getDescription())
                ->setContexte($brief->getContexte())
                ->setNomBrief($brief->getNomBrief())
                ->setModalitePedagogique($brief->getModalitePedagogique())
                ->setCritereEvaluation($brief->getCritereEvaluation())
                ->setModaliteEvaluation($brief->getModaliteEvaluation())
                ->setArchiver($brief->getArchiver())
                ->setCreatedAt($brief->getCreatedAt())
                ->setEtat($brief->getEtat())
            
                ;
                $entityManagerInterface->persist($briefDup);
                $entityManagerInterface->flush();
        }
        return $this->json("Duplication réussie!");
    }

}
