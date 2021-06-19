<?php

declare(strict_types=1);

namespace App\Api\Book\Factory;

use App\Api\Book\Dto\AuthorResponseDto;
use App\Api\Book\Dto\BookResponseDto;
use App\Core\Book\Document\Author;
use App\Core\Book\Document\Book;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * @param Book $book
     * @param Author|null $author
     *
     * @return BookResponseDto
     */
    public function createBookResponse(Book $book, ?author $author = null): BookResponseDto
    {
        $dto = new BookResponseDto();

        $dto->id = $book->getId();
        $dto->name = $book->getName();
        $dto->status = $book->getStatus();
        $dto->isbn = $book->getIsbn();

        if ($author) {
            $AuthorResponseDto = new AuthorResponseDto();
            $AuthorResponseDto->id = $author->getId();
            $AuthorResponseDto->author = $author->getAuthor();

            $dto->author = $AuthorResponseDto;
        }

        return $dto;
    }
}
