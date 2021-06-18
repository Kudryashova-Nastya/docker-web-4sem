<?php

declare(strict_types=1);

namespace App\Core\Book\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Book\Repository\AuthorRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\ODM\MongoDB\Mapping\Annotations\ReferenceOne;

/**
 * @MongoDB\Document(repositoryClass=AuthorRepository::class, collection="type")
 */
class Author extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\UniqueIndex(name="book_type")
     */
    protected string $author;

    /**
     * @ReferenceOne(targetDocument=Book::class)
     */
    protected Book $book;

    public function __construct(string $author, Book $book)
    {
        $this->author = $author;
        $this->book  = $book;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getBook(): Book
    {
        return $this->book;
    }
}
