<?php

declare(strict_types=1);

namespace App\Api\Book\Dto;

class BookListResponseDto
{
    public array $data;

    public function __construct(BookResponseDto ...$data)
    {
        $this->data = $data;
    }
}
