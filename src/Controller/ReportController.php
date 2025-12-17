<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\PeopleRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function dashboard(
        PeopleRepository $peopleRepo,
        OrderRepository $orderRepo,
        BookRepository $bookRepo
    ): Response {
        return $this->render('report/dashboard.html.twig', [
            'customers' => $peopleRepo->findPeopleWithOrderCount(),
            'topSpenders' => $peopleRepo->findTopSpenders(3),
            'averageOrder' => $orderRepo->findAverageOrderTotal(),
            'goldBook' => $bookRepo->findMostExpensiveBook(),
        ]);
    }

    #[Route('/reports/orders', name: 'report_orders')]
    public function listOrders(OrderRepository $orderRepo): Response
    {
        $orders = $orderRepo->createQueryBuilder('o')
            ->leftJoin('o.people', 'p')->addSelect('p')
            ->leftJoin('o.books', 'b')->addSelect('b')
            ->getQuery()
            ->getResult();

        return $this->render('report/orders.html.twig', ['orders' => $orders]);
    }
}