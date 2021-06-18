<?php

declare(strict_types=1);

namespace App\Core\Book\Repository;

use App\Core\Common\Repository\AbstractRepository;
use App\Core\Book\Document\Book;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Book save(Book $book)
 * @method Book|null find(string $id)
 * @method Book|null findOneBy(array $criteria)
 * @method Book getOne(string $id)
 */
class BookRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Book::class;
    }

    /**
     * @throws LockException
     * @throws MappingException
     */
    public function getBookById(string $id): ?Book
    {
        return $this->find($id);
    }
}
