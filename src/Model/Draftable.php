<?php

namespace App\Model;

interface Draftable
{
    public function isDraft(): bool;

    public function setDraft(bool $draft): self;

}