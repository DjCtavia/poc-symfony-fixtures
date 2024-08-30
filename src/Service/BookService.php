<?php

namespace App\Service;

use App\Dto\BookDto;
use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class BookService
{
    public function __construct(
        private EntityManagerInterface $em,
        private BookRepository $bookRepository,
    ) {}

    public function create(BookDto $bookDto, ?string $id = null): string
    {
        $book = new Book(
            id: $id,
            name: $bookDto->getName(),
            isbn: $bookDto->getIsbn()
        );

        $this->em->persist($book);
        $this->em->flush();

        return $book->getId();
    }

    public function read(string $id): ?Book
    {
        return $this->bookRepository->find($id);
    }

    public function update(BookDto $bookDto, string $id): void
    {
        $book = $this->bookRepository->find($id);
        $book->setName($bookDto->getName());
        $book->setIsbn($bookDto->getIsbn());

        $this->em->flush();
    }

    public function delete(string $id): void
    {
        $book = $this->bookRepository->find($id);

        if (!$book) return;
        $this->em->remove($book);
        $this->em->flush();
    }
}