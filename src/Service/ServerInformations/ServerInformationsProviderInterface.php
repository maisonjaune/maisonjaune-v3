<?php

namespace App\Service\ServerInformations;

interface ServerInformationsProviderInterface
{
    public function getAvailableSpace();

    public function getDatabaseUsedSpace();

    public function getTotalSpace();

    public function getPercentAvailableSpace();
}