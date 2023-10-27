<?php

namespace App\Model;

use DateTimeImmutable;

interface Publiable
{
    public function isPublished(): bool;

    public function getPublishedAt(): ?DateTimeImmutable;

    public function setPublishedAt(?DateTimeImmutable $publishedAt): self;
}