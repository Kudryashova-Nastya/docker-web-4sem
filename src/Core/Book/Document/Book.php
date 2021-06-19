<?php

declare(strict_types=1);

namespace App\Core\Book\Document;

use App\Core\Common\Document\AbstractDocument;
use App\Core\Book\Repository\BookRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document(repositoryClass=BookRepository::class, collection="books")
 */
class Book extends AbstractDocument
{
    /**
     * @MongoDB\Id
     */
    protected ?string $id = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $name  = null;

    /**
     * @MongoDB\Field(type="string")
     */
    protected ?string $status = null;

    /**
     * @MongoDB\Field(type="string")
     * @MongoDB\UniqueIndex(name="book_isbn")
     */
    protected string $isbn;


    public function __construct(
        string $name,
        string $status,
        string $isbn
    ) {
        $this->name  = $name;
        $this->status  = $status;
        $this->isbn  = $isbn;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }
}
