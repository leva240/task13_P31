<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\People;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestDataController extends AbstractController
{
    #[Route('/test-data', name: 'test_data')]
    public function createTestData(EntityManagerInterface $em): Response
    {
        // === КНИГИ ===
        $book1 = new Book();
        $book1->setName('Война и мир')->setPrice('1200.00');
        $em->persist($book1);

        $book2 = new Book();
        $book2->setName('Мастер и Маргарита')->setPrice('800.50');
        $em->persist($book2);

        // === ПОКУПАТЕЛИ ===
        $people1 = new People();
        $people1->setName('Иван Иванов')->setEmail('ivan@example.com');
        $em->persist($people1);

        $people2 = new People();
        $people2->setName('Мария Петрова')->setEmail('maria@example.com');
        $em->persist($people2);

        // === ЗАКАЗЫ ===
        $order1 = new Order();
        $order1->setPeople($people1); // ← обязательно
        $order1->addBook($book1);
        $em->persist($order1);
        
        $order2 = new Order();
        $order2->setPeople($people2);
        $order2->addBook($book2);
        $em->persist($order2);

        $em->flush();
        return new Response('Готово!');
    }
}