<?php

declare(strict_types=1);

namespace App\Api\Book\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookCreateRequestDto
{
    /**
     * @Assert\Length(max=50, min=1)
     */
    public string $name = '';

    /**
     * @Assert\Length(max=20, min=3)
     */
    public string $status = 'В наличии';

    /**
     * @Assert\Length(17)
     */
    public string $isbn = '';
}
