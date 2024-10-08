<?php

namespace App\Entity;

use App\Repository\UserBookBorrowRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserBookBorrowRepository::class)]
class UserBookBorrow
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', unique: true)]
    private ?string $id = null;

    #[ORM\ManyToOne(inversedBy: 'userBookBorrows')]
    private ?User $borrower = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $due_date_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct(
        ?string $id,
        ?User $borrower,
        ?\DateTimeImmutable $due_date_at,
        ?\DateTimeImmutable $created_at,
        ?\DateTimeImmutable $updated_at
    ) {
        $this->id = $id;
        $this->borrower = $borrower;
        $this->due_date_at = $due_date_at;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getBorrower(): ?User
    {
        return $this->borrower;
    }

    public function setBorrower(?User $borrower): static
    {
        $this->borrower = $borrower;

        return $this;
    }

    public function getDueDateAt(): ?\DateTimeImmutable
    {
        return $this->due_date_at;
    }

    public function setDueDateAt(\DateTimeImmutable $due_date_at): static
    {
        $this->due_date_at = $due_date_at;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
