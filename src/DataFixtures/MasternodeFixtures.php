<?php

namespace App\DataFixtures;

use App\Entity\Masternode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class MasternodeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_GB');

        for ($i = 0; $i < 20; $i++) {
            $masternode = new Masternode();
            $masternode
                ->setAlias($faker->userName)
                ->setIp($faker->ipv4)
                ->setPort($faker->numberBetween(1458, 9854))
                ->setPrivateKey($faker->sha256)
                ->setTxId($faker->sha256)
                ->setTxOut($faker->numberBetween(0, 1));
            $manager->persist($masternode);
            $masternode->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
            $masternode->setCryptocurrency($this->getReference($i));
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CryptocurrencyFixtures::class];
    }
}
