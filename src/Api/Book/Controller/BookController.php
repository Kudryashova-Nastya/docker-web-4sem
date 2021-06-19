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

use App\Api\Book\Factory\ResponseFactory;
use App\Core\Common\Factory\HTTPResponseFactory;
use App\Core\Book\Service\BookService;

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
     * @param AuthorRepository $authorRepository
     * @param ResponseFactory $responseFactory
     *
     * @return BookResponseDto
     */
    public function show(Book $book = null, ResponseFactory $responseFactory)
    {
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $author = $authorRepository->findOneBy(['book' => $book]);

        return $responseFactory->createBookResponse($book, $author);
    }

    /**
     * @Route(path="", methods={"GET"})
     *
     * @IsGranted(Permission::BOOK_INDEX)
     *
     * @Rest\View()
     *
     * @return BookListResponseDto|ValidationFailedResponse
     * @param ResponseFactory $responseFactory
     */
    public function index(
        Request $request,
        BookRepository $bookRepository,
        ResponseFactory $responseFactory
    ): BookListResponseDto {
        $page = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $books = $bookRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new BookListResponseDto(
            ...array_map(
                function (Book $book) use ($responseFactory) {
                    return $responseFactory->createBookResponse($book);
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
     * @param ResponseFactory $responseFactory
     * @param HTTPResponseFactory $HTTPResponseFactory
     * @param BookService $service
     *
     * @return BookResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        BookCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        ResponseFactory $responseFactory,
        HTTPResponseFactory $HTTPResponseFactory,
        BookService $service
    ) {
        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createBookResponse($service->createBook($requestDto));
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
     * @param ResponseFactory $responseFactory
     *
     * @return BookResponseDto|ValidationFailedResponse|Response
     */
    public function createAuthor(
        Request $request,
        Book $book = null,
        AuthorRepository $authorRepository,
        ResponseFactory $responseFactory
    ) {
        $author = new Author($request->get('author', ''), $book);
        $authorRepository->save($author);

        return $responseFactory->createBookResponse($book, $author);
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
     * @param ResponseFactory $responseFactory
     * @param HTTPResponseFactory $HTTPResponseFactory
     * @param BookService $service
     *
     * @return BookResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Book $book = null,
        BookUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        BookRepository $bookRepository,
        ResponseFactory $responseFactory,
        HTTPResponseFactory $HTTPResponseFactory,
        BookService $service
    ) {
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createBookResponse($service->updateBook($book, $requestDto));
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
     * @param ResponseFactory $responseFactory
     * @param BookService $service
     *
     * @return BookResponseDto|ValidationFailedResponse
     */
    public function delete(
        Book $book = null,
        BookService $service
    ) {
        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $service->deleteBook($book);
        return "book deleted";
    }
}
