<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'book_order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?People $people = null;

    #[ORM\ManyToMany(targetEntity: Book::class)]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getTotal(): string
    {
        $total = '0';
        foreach ($this->books as $book) {
            $total = bcadd($total, $book->getPrice(), 2);
        }
        return $total;
    }

    // Геттеры и сеттеры
    public function getId(): ?int { return $this->id; }
    public function getPeople(): ?People { return $this->people; }
    public function setPeople(?People $people): self { $this->people = $people; return $this; }
    public function getBooks(): Collection { return $this->books; }
    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }
        return $this;
    }
}