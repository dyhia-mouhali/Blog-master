<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create('fr_FR');

        for($i=0;$i<15;$i++)
        {
            $post=new Post();
            $title=$faker->sentence($nbWords=5, $variableNbWords = true);
            $post->setTitle($title)
                ->setContent($faker->text($maxNbChars = 10000));

            $manager->persist($post);
        }

        $manager->flush();
    }
}
