<?php

declare(strict_types=1);

namespace App\Core\Book\Repository;


use App\Core\Common\Repository\AbstractRepository;
use App\Core\Book\Document\Author;
use Doctrine\ODM\MongoDB\LockException;
use Doctrine\ODM\MongoDB\Mapping\MappingException;

/**
 * @method Author save(Author $type)
 * @method Author|null find(string $id)
 * @method Author|null findOneBy(array $criteria)
 * @method Author getOne(string $id)
 */
class AuthorRepository extends AbstractRepository
{
    public function getDocumentClassName(): string
    {
        return Author::class;
    }

    /**
     * @throws LockException
     * @throws MappingException|MappingException
     */
    public function getAuthorById(string $id): ?Author
    {
        return $this->find($id);
    }
}
