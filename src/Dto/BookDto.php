<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class BookDto
{
    #[Assert\NotBlank(groups: ['create', 'update'])]
    #[Assert\Length(min: 1, max: 255, groups: ['create', 'update'])]
    private string $name;

    #[Assert\NotBlank(groups: ['create', 'update'])]
    #[Assert\Isbn(groups: ['create', 'update'])]
    private string $isbn;

    public function __construct(
        ?string $name = null,
        ?string $isbn = null
    ) {
        $this->name = $name;
        $this->isbn = $isbn;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
}