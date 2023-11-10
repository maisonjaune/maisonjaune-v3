<?php

namespace App\Twig\Components\Analytics;

use App\Service\Analytics\AnalyticsInterface;
use App\Service\Analytics\Model\VisitCollection;
use DateTimeImmutable;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/Analytics/VisitGraph.html.twig')]
final class VisitGraph
{
    public VisitCollection $visits;

    public VisitCollection $uniqueVisits;

    public Chart $chart;

    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private AnalyticsInterface    $analytics,
        private TranslatorInterface   $translator,
    )
    {
        $this->visits = $this->analytics->getVisits();
        $this->uniqueVisits = $this->analytics->getUniqueVisits();

        $this->chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $this->chart->setData([
            'labels' => array_map(
                fn(DateTimeImmutable $date) => $date->format('d/m/Y'),
                $this->visits->getDates()
            ),
            'datasets' => [
                [
                    'label' => $this->translator->trans('Visitors'),
                    'backgroundColor' => '#3498db',
                    'borderColor' => '#2980b9',
                    'data' => $this->visits->getValues(),
                    'tension' => 0.25,
                ],
                [
                    'label' => $this->translator->trans('Unique visitors'),
                    'backgroundColor' => '#2ecc71',
                    'borderColor' => '#27ae60',
                    'data' => $this->uniqueVisits->getValues(),
                    'tension' => 0.25,
                ],
            ],
        ]);
        $this->chart->setOptions([
            'maintainAspectRatio' => true,
        ]);
    }
}
