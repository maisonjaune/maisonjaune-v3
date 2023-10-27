<?php

namespace App\Model;

interface Reviewable
{
    public function isReviewed(): ?bool;

    public function setReviewed(bool $reviewed): self;
}