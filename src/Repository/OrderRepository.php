<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findAverageOrderTotal(): string
    {
        $orders = $this->findAll();
        if (empty($orders)) return '0.00';

        $totalSum = '0';
        foreach ($orders as $order) {
            $totalSum = bcadd($totalSum, $order->getTotal(), 2);
        }
        return bcdiv($totalSum, (string)count($orders), 2);
    }
}