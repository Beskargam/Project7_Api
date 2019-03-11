<?php

namespace App\DataFixtures;

use App\Entity\Token;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TokenFixtures extends Fixture implements DependentFixtureInterface
{
    public const TOKEN_ACCESSTOKEN_REFERENCE = 'token-accesstoken';

    public function load(ObjectManager $manager)
    {
        /*
        $token = new Token();
        $token->setAccessToken('TestAccessToken---asda5s495f1ew4a6_as5d4a8sdasd-asd984g3a1eav8a88464asd');
        $token->setDateToken(new \DateTime());
        $manager->persist($token);
        $this->addReference(self::TOKEN_ACCESSTOKEN_REFERENCE, $token);

        $manager->flush();
        */
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
            ManufacturerFixtures::class,
            ArticleFixtures::class
        );
    }
}
