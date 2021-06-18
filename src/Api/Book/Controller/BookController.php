<?php

declare(strict_types=1);

namespace App\Api\Book\Controller;

use App\Api\Book\Dto\AuthorResponseDto;
use App\Api\Book\Dto\BookCreateRequestDto;
use App\Api\Book\Dto\BookListResponseDto;
use App\Api\Book\Dto\BookResponseDto;
use App\Api\Book\Dto\BookUpdateRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Book\Document\Author;
use App\Core\Book\Document\Book;

use App\Core\User\Enum\Permission;

use App\Core\Book\Repository\AuthorRepository;
use App\Core\Book\Repository\BookRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/books")
 */
class BookController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::BOOK_SHOW)
     *
     * @ParamConverter("book")
     *
     * @Rest\View()
     *
     * @param Book|null $book
     *
     * @return BookResponseDto
     */
    public function show(Book $book = null)
    {
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->createBookResponse($book);
    }

    /**
     * @Route(path="", methods={"GET"})
     *
     * @IsGranted(Permission::BOOK_INDEX)
     *
     * @Rest\View()
     *
     * @return BookListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        BookRepository $bookRepository
    ): BookListResponseDto {
        $page = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $books = $bookRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new BookListResponseDto(
            ...array_map(
                function (Book $book) {
                    return $this->createBookResponse($book);
                },
                $books
            )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::BOOK_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param BookCreateRequestDto $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param BookRepository $bookRepository
     *
     * @return BookResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        BookCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BookRepository $bookRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $book = new Book(
            $requestDto->name,
            $requestDto->status,
            $requestDto->isbn
        );

        $bookRepository->save($book);

        return $this->createBookResponse($book);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}/author", methods={"POST"})
     * @IsGranted(Permission::BOOK_AUTHOR_CREATE)
     * @ParamConverter("book")
     *
     * @Rest\View(statusCode=201)
     *
     * @param Request $request
     * @param Book|null $book
     * @param AuthorRepository $authorRepository
     *
     * @return BookResponseDto|ValidationFailedResponse|Response
     */
    public function createAuthor(
        Request $request,
        Book $book = null,
        AuthorRepository $authorRepository
    ) {
        $author = new Author($request->get('author', ''), $book);
        $authorRepository->save($author);

        return $this->createBookResponse($book, $author);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::BOOK_UPDATE)
     * @ParamConverter("book")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param BookUpdateRequestDto $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param BookRepository $bookRepository
     *
     * @return BookResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Book $book = null,
        BookUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BookRepository $bookRepository
    ) {
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $book->setName($requestDto->name);
        $book->setStatus($requestDto->status);

        $bookRepository->save($book);

        return $this->createBookResponse($book);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::BOOK_DELETE)
     * @ParamConverter("book")
     *
     * @Rest\View()
     *
     * @param Book|null $book
     * @param BookRepository $bookRepository
     *
     * @return BookResponseDto|ValidationFailedResponse
     */
    public function delete(
        BookRepository $bookRepository,
        Book $book = null
    ) {
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $bookRepository->remove($book);
    }

    /**
     * @param Book $book
     *
     * @return BookResponseDto
     */
    private function createBookResponse(Book $book, ?Author $author = null): BookResponseDto
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
