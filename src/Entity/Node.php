<?php

namespace App\Entity;

use App\Model\Draftable;
use App\Model\Publiable;
use App\Repository\NodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NodeRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "node_type", type: "string")]
abstract class Node implements Draftable, Publiable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(groups: ['Default'])]
    protected ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(groups: ['Default'])]
    protected ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(groups: ['Content'])]
    protected ?string $content = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(groups: ['Publication'])]
    protected ?\DateTimeImmutable $publishedAt = null;

    #[ORM\Column]
    protected ?bool $actif = false;

    #[ORM\Column]
    protected bool $draft = true;

    #[ORM\Column]
    protected ?bool $sticky = false;

    #[ORM\Column]
    protected ?bool $commentable = true;

    #[ORM\ManyToOne]
    protected ?User $author = null;

    public function __construct()
    {
        $this->sticky = false;
        $this->commentable = true;
        $this->actif = false;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isPublished(): bool
    {
        return null !== $this->publishedAt
            && $this->publishedAt <= new \DateTimeImmutable();
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function setDraft(bool $draft): self
    {
        $this->draft = $draft;

        return $this;
    }

    public function isSticky(): ?bool
    {
        return $this->sticky;
    }

    public function setSticky(bool $sticky): self
    {
        $this->sticky = $sticky;

        return $this;
    }

    public function isCommentable(): ?bool
    {
        return $this->commentable;
    }

    public function setCommentable(bool $commentable): self
    {
        $this->commentable = $commentable;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
