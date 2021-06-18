<?php

declare(strict_types=1);

namespace App\Api\Book\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookUpdateRequestDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=30, min=3)
     */
    public ?string $name = null;

    public ?string $status = null;
}
