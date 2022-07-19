<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=question::class, mappedBy="category")
     */
    private $relation;

    /**
     * @ORM\ManyToOne(targetEntity=stack::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stacks;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestions(question $questions): self
    {
        if (!$this->questions->contains($questions)) {
            $this->questions[] = $questions;
            $questions->setCategory($this);
        }

        return $this;
    }

    public function removeQuestions(question $questions): self
    {
        if ($this->relation->removeElement($questions)) {
            // set the owning side to null (unless already changed)
            if ($questions->getCategory() === $this) {
                $questions->setCategory(null);
            }
        }

        return $this;
    }

    public function getStacks(): ?stack
    {
        return $this->stacks;
    }

    public function setStacks(?stack $stacks): self
    {
        $this->stacks = $stacks;

        return $this;
    }
}
