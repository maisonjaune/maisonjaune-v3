<?php

namespace App\Service\Analytics;

use App\Service\Analytics\Exception\DataUnavailableException;
use App\Service\Analytics\Model\VisitCollection;

interface AnalyticsInterface
{
    /**
     * @throws DataUnavailableException
     */
    public function getVisits(): VisitCollection;

    /**
     * @throws DataUnavailableException
     */
    public function getUniqueVisits(): VisitCollection;
}