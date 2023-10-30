<?php

namespace App\Twig\Components;

use App\Converter\ByteConverterInterface;
use App\Service\ServerInformations\ServerInformationsProviderInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent(template: 'components/ServerInformations.html.twig')]
final class ServerInformations
{
    public function __construct(
        private ServerInformationsProviderInterface $serverInformationsProvider,
        private ByteConverterInterface              $byteConverter,
    )
    {
    }

    public function getDiskAvailableSpace(): string
    {
        return $this->byteConverter->convert($this->serverInformationsProvider->getAvailableSpace());
    }

    public function getDiskTotalSpace(): string
    {
        return $this->byteConverter->convert($this->serverInformationsProvider->getTotalSpace());
    }

    public function getPercentAvailableSpace(): float
    {
        return $this->serverInformationsProvider->getPercentAvailableSpace();
    }

    public function getProgressbarBackgroundColor(): string
    {
        if ($this->serverInformationsProvider->getPercentAvailableSpace() > 90) {
            return 'progress-bar-danger';
        }

        if ($this->serverInformationsProvider->getPercentAvailableSpace() > 70) {
            return 'progress-bar-warning';
        }

        return 'progress-bar-info';
    }

    public function getDatabaseUsedSpace(): string
    {
        return $this->byteConverter->convert($this->serverInformationsProvider->getDatabaseUsedSpace());
    }
}
