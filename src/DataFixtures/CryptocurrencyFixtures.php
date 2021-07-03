<?php

namespace App\DataFixtures;

use App\Entity\Cryptocurrency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker;

class CryptocurrencyFixtures extends Fixture
{
    const CONSENSUS = [
        'POW',
        'POS',
        'POW/POS',
        'DPOS',
        'PBFT',
    ];

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('en_GB');

        for ($i = 0; $i < 40; $i++) {
            $cryptocurrency = new Cryptocurrency();
            $cryptocurrency
                ->setName($faker->firstName)
                ->setTicker($faker->word)
                ->setConsensus(self::CONSENSUS[random_int(0, 4)])
                ->setCollateral($faker->numberBetween(42, 100000000));
            $manager->persist($cryptocurrency);
            $this->addReference($i, $cryptocurrency);
        }
        $manager->flush();
    }
}
