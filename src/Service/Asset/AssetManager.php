<?php

namespace App\Service\Asset;

class AssetManager implements AssetManagerInterface
{
    /**
     * @var string[]
     */
    private array $webpackEntries = [];

    /**
     * @return string[]
     */
    public function getWebpackEntries(): array
    {
        return $this->webpackEntries;
    }

    public function addWebpackEncoreEntries(string ...$entries): self
    {
        $this->webpackEntries = array_merge($this->webpackEntries, $entries);

        return $this;
    }
}