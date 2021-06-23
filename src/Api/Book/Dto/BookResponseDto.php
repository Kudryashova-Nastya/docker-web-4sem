<?php

declare(strict_types=1);

namespace App\Api\Book\Dto;


class BookResponseDto
{
    public ?string $id = null;

    public string $name  = '';

    public string $status = '';

    public string $isbn = '';

    public ?AuthorResponseDto $author;
}
