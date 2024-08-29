<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Shelf>
     */
    #[ORM\OneToMany(targetEntity: Shelf::class, mappedBy: 'library')]
    private Collection $Shelves;

    public function __construct()
    {
        $this->Shelves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Shelf>
     */
    public function getShelves(): Collection
    {
        return $this->Shelves;
    }

    public function addShelf(Shelf $shelf): static
    {
        if (!$this->Shelves->contains($shelf)) {
            $this->Shelves->add($shelf);
            $shelf->setLibrary($this);
        }

        return $this;
    }

    public function removeShelf(Shelf $shelf): static
    {
        if ($this->Shelves->removeElement($shelf)) {
            // set the owning side to null (unless already changed)
            if ($shelf->getLibrary() === $this) {
                $shelf->setLibrary(null);
            }
        }

        return $this;
    }
}
