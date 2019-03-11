<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /*
        $user = new User();
        $user->setEmail('testEmail@test.com');
        $user->setUsername('TestName');
        $user->setRoles(['ROLE_USER']);
        $user->setRefreshToken('TestRefreshToken---safdg50059gk563hfghd54w-dawdawfgawfawg54a69g15a2sasdawd4asd');
        $accessToken = $this->getReference(TokenFixtures::TOKEN_ACCESSTOKEN_REFERENCE);
        $user->setAccessToken($accessToken);
        $manager->persist($user);

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
            TokenFixtures::class
        );
    }
}
