<?php

namespace App\Service\Asset;

interface AssetManagerInterface
{
    public function addWebpackEncoreEntries(string ...$entries): self;
}