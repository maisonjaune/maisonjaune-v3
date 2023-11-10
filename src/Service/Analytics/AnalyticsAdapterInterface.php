<?php

namespace App\Service\Analytics;

use App\Service\Analytics\Model\VisitCollection;

interface AnalyticsAdapterInterface
{
    public function getVisitsSummary(): VisitCollection;

    public function getUniqueVisitsSummary(): VisitCollection;
}