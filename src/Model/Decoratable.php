<?php

namespace App\Model;

interface Decoratable
{
    public function isDecorated(): ?bool;

    public function setDecorated(bool $decorated): self;
}