<?php

namespace App\Service\Analytics;

use App\Service\Analytics\Model\VisitCollection;

class Analytics implements AnalyticsInterface
{
    private AnalyticsAdapterInterface $adapter;

    public function getVisits(): VisitCollection
    {
        return $this->adapter->getVisitsSummary();
    }

    public function getUniqueVisits(): VisitCollection
    {
        return $this->adapter->getUniqueVisitsSummary();
    }

    public function setAdapter(AnalyticsAdapterInterface $adapter): self
    {
        $this->adapter = $adapter;

        return $this;
    }
}