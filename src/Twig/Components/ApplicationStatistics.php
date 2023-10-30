<?php

namespace App\Twig\Components;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/ApplicationStatistics.html.twig')]
final class ApplicationStatistics
{
    public function __construct(
        #[TaggedIterator('app.block.statistic')] public \IteratorAggregate $blocks,
    )
    {
    }
}
