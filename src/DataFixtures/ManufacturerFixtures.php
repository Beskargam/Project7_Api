<?php

namespace App\DataFixtures;

use App\Entity\Manufacturer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ManufacturerFixtures extends Fixture
{
    public const MANUFACTURER_SAMSUNG_REFERENCE = 'manufacturer-samsung';
    public const MANUFACTURER_NOKIA_REFERENCE = 'manufacturer-nokia';
    public const MANUFACTURER_XIAOMI_REFERENCE = 'manufacturer-xiaomi';

    public function load(ObjectManager $manager)
    {
        $manufacturer = new Manufacturer();
        $manufacturer->setManufacturerName('Samsung');
        $manager->persist($manufacturer);
        $this->addReference(self::MANUFACTURER_SAMSUNG_REFERENCE, $manufacturer);

        $manufacturer = new Manufacturer();
        $manufacturer->setManufacturerName('Nokia');
        $manager->persist($manufacturer);
        $this->addReference(self::MANUFACTURER_NOKIA_REFERENCE, $manufacturer);

        $manufacturer = new Manufacturer();
        $manufacturer->setManufacturerName('Xiaomi');
        $manager->persist($manufacturer);
        $this->addReference(self::MANUFACTURER_XIAOMI_REFERENCE, $manufacturer);

        $manager->flush();
    }
}
