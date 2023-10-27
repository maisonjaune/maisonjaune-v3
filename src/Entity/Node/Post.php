<?php

namespace App\Entity\Node;

use App\Entity\Node;
use App\Model\Decoratable;
use App\Model\Reviewable;
use App\Repository\Node\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: "node_post")]
class Post extends Node implements Reviewable, Decoratable
{
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(groups: ['Content'])]
    private ?string $excerpt = null;

    #[ORM\Column]
    private bool $reviewed = false;

    #[ORM\Column]
    private bool $decorated = false;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    private Collection $categories;

    public function __construct()
    {
        parent::__construct();
        $this->categories = new ArrayCollection();
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function setExcerpt(?string $excerpt): self
    {
        $this->excerpt = $excerpt;

        return $this;
    }

    public function isReviewed(): ?bool
    {
        return $this->reviewed;
    }

    public function setReviewed(bool $reviewed): self
    {
        $this->reviewed = $reviewed;

        return $this;
    }

    public function isDecorated(): ?bool
    {
        return $this->decorated;
    }

    public function setDecorated(bool $decorated): self
    {
        $this->decorated = $decorated;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
