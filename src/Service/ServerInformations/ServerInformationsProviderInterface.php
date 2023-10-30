<?php

namespace App\Service\ServerInformations;

interface ServerInformationsProviderInterface
{
    public function getAvailableSpace(): float;

    public function getDatabaseUsedSpace(): float;

    public function getTotalSpace(): float;

    public function getPercentAvailableSpace(): float;
}