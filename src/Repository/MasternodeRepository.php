<?php

namespace App\Repository;

use App\Entity\Masternode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Masternode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Masternode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Masternode[]    findAll()
 * @method Masternode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MasternodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Masternode::class);
    }
}
