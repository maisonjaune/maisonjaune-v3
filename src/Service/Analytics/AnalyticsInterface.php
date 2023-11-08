<?php

namespace App\Service\Analytics;

use App\Service\Analytics\Model\VisitCollection;

interface AnalyticsInterface
{
    public function getVisits(): VisitCollection;

    public function getUniqueVisits(): VisitCollection;
}