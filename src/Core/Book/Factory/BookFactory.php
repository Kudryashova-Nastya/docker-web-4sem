<?php

declare(strict_types=1);

namespace App\Core\Book\Factory;

use App\Core\Book\Document\Book;

class BookFactory
{
    public function create(
        string $isbn,
        string $name,
        string $status
    ): Book {
        $book = new Book(
            $isbn,
            $name,
            $status
        );

        return $book;
    }
    public function update(
        Book $book = null,
        string $name,
        string $status
    ): Book {
        $book->setName($name);
        $book->setStatus($status);

        return $book;
    }
}
