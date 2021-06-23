<?php

declare(strict_types=1);

namespace App\Api\Book\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class BookUpdateRequestDto
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=50, min=1)
     */
    public string $name = '';

    /**
     * @Assert\Length(max=20, min=3)
     */
    public string $status = '';
}
