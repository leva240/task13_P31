<?php

namespace App\Repository;

use App\Entity\People;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PeopleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, People::class    );
    }

    public function findPeopleWithOrderCount()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, p.email, COUNT(o.id) as orderCount')
            ->leftJoin('p.orders', 'o')
            ->groupBy('p.id')
            ->orderBy('orderCount', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findTopSpenders(int $limit = 3)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, p.email, SUM(b.price) as totalSpent')
            ->leftJoin('p.orders', 'o')
            ->leftJoin('o.books', 'b')
            ->groupBy('p.id')
            ->orderBy('totalSpent', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}