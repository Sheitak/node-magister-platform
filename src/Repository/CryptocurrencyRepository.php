<?php

namespace App\Repository;

use App\Entity\Cryptocurrency;
use App\Entity\CryptocurrencySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * @method Cryptocurrency|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cryptocurrency|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cryptocurrency[]    findAll()
 * @method Cryptocurrency[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CryptocurrencyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cryptocurrency::class);
    }

    /**
     * @param CryptocurrencySearch $search
     * @return Query
     */
    public function findCryptoQuery(CryptocurrencySearch $search): Query
    {
        $query = $this->findAllCryptoQuery();

        if ($search->getConsensus()) {
            $query = $query
                ->andWhere('c.consensus = :consensus')
                ->setParameter('consensus', $search->getConsensus());
        }

        if ($search->getMinCollateral()) {
            $query = $query
                ->andWhere('c.collateral >= :mincollateral')
                ->setParameter('mincollateral', $search->getMinCollateral());
        }

        return $query->getQuery();
    }


    private function findAllCryptoQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->select('c');
    }
}
