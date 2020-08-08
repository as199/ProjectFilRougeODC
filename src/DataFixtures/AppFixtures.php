<?php

namespace App\DataFixtures;

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
            if ($libelle =="ADMIN"){
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
            }elseif ($libelle =="APPRENANT") {
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
            }elseif ($libelle =="CM") {
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
            }else{
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

            $manager->flush();
        }
    }
}
