<?php

namespace App\Service\Statistics;

interface BlockStatisticInterface
{
    public function getTitle(): string;

    public function getStat(): mixed;

    public function getIconClass(): string;

    public function getBackgroundColor(): string;
}