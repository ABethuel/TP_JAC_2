<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Comment;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create("fr_FR");

        // Create 3 categories
        for ($i=1; $i <= 3; $i++){
            $type = new Type();
            $type->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());

            $manager -> persist($type);

            // create post

            for ($j = 1; $j <= mt_rand(4,8); $j++){
                $annonce = new Annonce();

                $annonce->setTitle($faker->sentence())
                        ->setContent($faker->paragraph())
                        ->setImage($faker->imageUrl())
                        ->setCategory($type->getTitle())
                        ->setDate($faker->dateTimeBetween('-6 months'))
                        ->setType($type);

                $manager->persist($annonce);

                // Comments
                for ($k = 1; $k <= mt_rand(4, 10); $k++){
                    $comment = new Comment();

                    $date = new \DateTime();
                    $interval = $date -> diff($annonce->getDate());
                    $days = $interval->days;
                    $min = '-' . $days . ' days';

                    $comment->setAuthor($faker->name)
                            ->setContent($faker->paragraph())
                            ->setCreatedAt($faker->dateTimeBetween($min))
                            ->setAnnonce($annonce);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
        /*
        $annonce1 = new Annonce();
        $annonce1 -> setTitle("Tarte aux pommes")
            -> setContent("Tarte aux pomme concoctée avec amour")
            -> setCategory("dessert")
            -> setImage("https://static.750g.com/images/600-600/9823eb627203c878f3e36d72f8ce6d1c/tarte-aux-pommes.jpg")
            -> setDate(new \DateTime());

        $annonce2 = new Annonce();
        $annonce2 -> setTitle("Sandwich au thon")
            -> setContent("Sandwich au thon concocté avec amour")
            -> setCategory("Sandwich")
            -> setImage("https://assets.afcdn.com/recipe/20160928/21224_w1024h1024c1cx2128cy1416.webp")
            -> setDate(new \DateTime());

        $annonce3 = new Annonce();
        $annonce3 -> setTitle("McDo")
            -> setContent("McDo concocté avec amour")
            -> setCategory("Fast food")
            -> setImage("https://static.actu.fr/uploads/2020/04/mcdo-pres-lille-drive-24h-sur-24.jpg")
            -> setDate(new \DateTime());

        $manager->persist($annonce1);
        $manager->persist($annonce2);
        $manager->persist($annonce3);

        $manager->flush();
         */

    }
}
