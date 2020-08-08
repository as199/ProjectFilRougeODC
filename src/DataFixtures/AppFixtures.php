<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\Groupe;
use App\Entity\GroupeCompetence;
use App\Entity\GroupeTag;
use App\Entity\Niveau;
use App\Entity\ProfilSorti;
use App\Entity\Promo;
use App\Entity\Referenciel;
use App\Entity\Tag;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Admin;
use App\Entity\Profil;
use App\Entity\Formateur;
use App\Entity\Cm;
use App\Entity\Apprenant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $profils = ["ADMIN", "FORMATEUR", "APPRENANT", "CM"];
        foreach ($profils as $key => $libelle) {
            $profil = new Profil();
            $profil->setLibelle($libelle);
            $manager->persist($profil);
            $manager->flush();
            if ($libelle == "ADMIN") {
                for ($i = 1; $i <= 3; $i++) {
                    $admin = new Admin();
                    $admin->setProfil($profil)
                        ->setTelephone($faker->phoneNumber)
                        ->setUsername($faker->userName)
                        ->setEmail(strtolower($libelle) . $i . '@gmail.com')
                        ->setPrenom($faker->firstName)
                        ->setNom($faker->lastName)
                        ->setAdresse($faker->address);
                    //Génération des User
                    $password = $this->encoder->encodePassword($admin, 'pass1234');
                    $admin->setPassword($password);

                    $manager->persist($admin);
                }
            } elseif ($libelle == "APPRENANT") {
                for ($i = 1; $i <= 3; $i++) {
                    $user = new Apprenant();
                    $user->setProfil($profil)
                        ->setTelephone($faker->phoneNumber)
                        ->setUsername($faker->userName)
                        ->setEmail(strtolower($libelle) . $i . '@gmail.com')
                        ->setPrenom($faker->firstName)
                        ->setNom($faker->lastName)
                        ->setAdresse($faker->address);
                    //Génération des Users
                    $password = $this->encoder->encodePassword($user, 'pass1234');
                    $user->setPassword($password);

                    $manager->persist($user);
                }
            } elseif ($libelle == "CM") {
                for ($i = 1; $i <= 3; $i++) {
                    $cm = new Cm();
                    $cm->setProfil($profil)
                        ->setTelephone($faker->phoneNumber)
                        ->setUsername($faker->userName)
                        ->setEmail(strtolower($libelle) . $i . '@gmail.com')
                        ->setPrenom($faker->firstName)
                        ->setNom($faker->lastName)
                        ->setAdresse($faker->address);
                    //Génération des Users
                    $password = $this->encoder->encodePassword($user, 'pass1234');
                    $cm->setPassword($password);

                    $manager->persist($cm);
                }
            } else {
                for ($i = 1; $i <= 3; $i++) {
                    $user = new Formateur();
                    $user->setProfil($profil)
                        ->setTelephone($faker->phoneNumber)
                        ->setUsername($faker->userName)
                        ->setEmail(strtolower($libelle) . $i . '@gmail.com')
                        ->setPrenom($faker->firstName)
                        ->setNom($faker->lastName)
                        ->setAdresse($faker->address);
                    //Génération des Users
                    $password = $this->encoder->encodePassword($user, 'pass1234');
                    $user->setPassword($password);

                    $manager->persist($user);
                }
            }
        }
            $competence = ["Competence1", "Competence2", "Competence3"];
            foreach ($competence as $key => $libell) {
                $comp = new Competence();
                $comp->setLibelle($libell);
                $manager->persist($comp);
            }
            $competences = ["groupecompetence1", "groupecompetence2", "groupecompetence3"];
            foreach ($competences as $key => $libelle) {
                $comp = new GroupeCompetence();
                $comp->setLibelle($libelle);
                $manager->persist($comp);
            }
            $promos = ["promo1", "promo2", "promo3"];
            foreach ($promos as $key => $libelle) {
                if ($libelle == "promo1") {
                    $promo = new Promo();
                    $promo->setNomPromotion($libelle)
                        ->setDateDebut(new \DateTime("2010-12-16"))
                        ->setDateFin(new \DateTime("2014-12-16"));
                    $manager->persist($promo);
                    $manager->flush();

                        $groupes =["groupe1","groupe2","groupe3"];
                        foreach ($groupes as $key => $libelle){
                            $groupe = new Groupe();
                            $groupe->setNomGroupe($libelle)
                                ->setPromos($promo);
                            $manager->persist($groupe);

                    }
                }elseif ($libelle == "promo2") {
                    $promo = new Promo();
                    $promo->setNomPromotion($libelle)
                        ->setDateDebut(new \DateTime("2014-12-16"))
                        ->setDateFin(new \DateTime("2016-12-16"));
                    $manager->persist($profil);
                    $manager->flush();

                        $groupes =["groupe1","groupe2","groupe3","groupe4","groupe5"];
                        foreach ($groupes as $key => $libelle){
                            $groupe = new Groupe();
                            $groupe->setNomGroupe($libelle)
                                ->setPromos($promo);
                            $manager->persist($groupe);

                    }
                }elseif ($libelle == "promo3") {
                    $promo = new Promo();
                    $promo->setNomPromotion($libelle)
                        ->setDateDebut(new \DateTime("2016-12-16"))
                        ->setDateFin(new \DateTime("2019-12-16"));
                    $manager->persist($promo);
                    $manager->flush();

                        $groupes =["groupe1","groupe2","groupe3","groupe4","groupe5","groupe6","groupe7","groupe8","groupe9"];
                        foreach ($groupes as $key => $libelle){
                            $groupe = new Groupe();
                            $groupe->setNomGroupe($libelle)
                                ->setPromos($promo);
                            $manager->persist($groupe);

                    }
                }
            }
            $tags =["tag1","tag2","tag3","tag4"];
               foreach ($tags as $key => $libelle) {
                   $tag = new  Tag();
                   $tag->setLibelle($libelle);
                   $manager->persist($tag);
               }



        $tagroup = ["groupeTag1","groupeTag2","groupeTag3"];
        foreach ($tagroup as $key => $libelle) {
            $tagr = new  GroupeTag();
            $tagr->setLibelle($libelle);
            $manager->persist($tagr);
        }
        $niveaux = ["niveau1","niveau2","niveau3"];
        foreach ($niveaux as $key => $libelle) {
            $niveau = new  Niveau();
            $niveau->setLibelle($libelle);
            $manager->persist($niveau);
        }
        $referenciel = ["referenciel1","referenciel2","referenciel3"];
        foreach ($referenciel as $key => $libelle) {
            $referenciel = new  Referenciel();
            $referenciel->setLibelle($libelle);
            $manager->persist($referenciel);
        }
        $profilso = ["profilSorti1","profilSorti2","profilSorti3"];
        foreach ($profilso as $key => $libelle) {
            $profilsorti = new  ProfilSorti();
            $referenciel->setLibelle($libelle);
            $manager->persist($referenciel);
        }
        $manager->flush();
    }
}
