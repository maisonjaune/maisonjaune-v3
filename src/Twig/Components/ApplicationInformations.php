<?php

namespace App\Twig\Components;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/ApplicationInformations.html.twig')]
final class ApplicationInformations
{
    public function getPhpVersion()
    {
        return PHP_VERSION;
    }

    public function getSymfonyVersion()
    {
        return Kernel::VERSION;
    }

    public function getEndOfMaintenance()
    {
        return Kernel::END_OF_MAINTENANCE;
    }

    public function getEndOfLife()
    {
        return Kernel::END_OF_LIFE;
    }
}
