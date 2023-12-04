<?php

namespace App\Service\Asset;

interface AssetManagerInterface
{
    /**
     * @return string[]
     */
    public function getWebpackEntries(): array;

    public function addWebpackEncoreEntries(string ...$entries): self;
}