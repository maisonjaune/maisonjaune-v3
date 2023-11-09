<?php

namespace App\Twig\Components\Analytics;

use App\Service\Analytics\AnalyticsInterface;
use App\Service\Analytics\Model\VisitCollection;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/Analytics/VisitGraph.html.twig')]
final class VisitGraph
{
    public VisitCollection $visits;

    public VisitCollection $uniqueVisits;

    public function __construct(
        private AnalyticsInterface $analytics
    )
    {
        $this->visits = $this->analytics->getVisits();
        $this->uniqueVisits = $this->analytics->getUniqueVisits();
    }
}
