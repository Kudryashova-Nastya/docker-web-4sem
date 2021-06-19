<?php

declare(strict_types=1);

namespace App\Api\Book\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookCreateRequestDto
{
    /**
     * @Assert\Length(max=50, min=1)
     */
    public ?string $name = null;

    /**
     * @Assert\Length(max=20, min=1)
     */
    public ?string $status = null;

    /**
     * @Assert\Length(17)
     */
    public string $isbn = '';
}
