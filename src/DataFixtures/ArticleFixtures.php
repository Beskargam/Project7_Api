<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setName('Galaxy S9');
        $article->setDescription(
            'Un téléphone galactique');
        $manufacturer = $this->getReference(ManufacturerFixtures::MANUFACTURER_SAMSUNG_REFERENCE);
        $article->setManufacturer($manufacturer);
        $article->setPrice(800);
        $manager->persist($article);

        $article = new Article();
        $article->setName('7 Plus');
        $article->setDescription(
            'Le 7 plus est un très bon téléphone d\'après les avis utilisateurs');
        $manufacturer = $this->getReference(ManufacturerFixtures::MANUFACTURER_NOKIA_REFERENCE);
        $article->setManufacturer($manufacturer);
        $article->setPrice(700);
        $manager->persist($article);

        $article = new Article();
        $article->setName('Redmi 5 Plus');
        $article->setDescription(
            'Le meilleur smartphone qualité/prix du moment !');
        $manufacturer = $this->getReference(ManufacturerFixtures::MANUFACTURER_XIAOMI_REFERENCE);
        $article->setManufacturer($manufacturer);
        $article->setPrice(160);
        $manager->persist($article);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            ManufacturerFixtures::class
        );
    }
}
