<?php

namespace App\Twig\Components;

use App\Service\ServerInformations\ServerInformationsProviderInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/ServerInformations.html.twig')]
final class ServerInformations
{
    public function __construct(
        private ServerInformationsProviderInterface $serverInformationsProvider
    )
    {
    }

    public function getDiskAvailableSpace()
    {
        return $this->serverInformationsProvider->getAvailableSpace();
    }

    public function getDiskTotalSpace()
    {
        return $this->serverInformationsProvider->getTotalSpace();
    }

    public function getPercentAvailableSpace()
    {
        return $this->serverInformationsProvider->getPercentAvailableSpace();
    }

    public function getProgressbarBackgroundColor()
    {
        if ($this->serverInformationsProvider->getPercentAvailableSpace() > 90) {
            return 'progress-bar-danger';
        }

        if ($this->serverInformationsProvider->getPercentAvailableSpace() > 70) {
            return 'progress-bar-warning';
        }

        return 'progress-bar-info';
    }

    public function getDatabaseUsedSpace()
    {
        return $this->serverInformationsProvider->getDatabaseUsedSpace();
    }
}
