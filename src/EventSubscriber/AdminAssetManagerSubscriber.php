<?php

namespace App\EventSubscriber;

use App\Service\Asset\AssetManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\AssetDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminAssetManagerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private AdminContextProvider $contextProvider,
        private AssetManagerInterface $assetManager,
    )
    {
    }

    public function onAfterCrudActionEvent(AfterCrudActionEvent $event): void
    {
        foreach ($this->assetManager->getWebpackEntries() as $entry) {
            $context = $this->contextProvider->getContext();

            if ($context instanceof AdminContext) {
                $context->getAssets()->addWebpackEncoreAsset(new AssetDto($entry));
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterCrudActionEvent::class => 'onAfterCrudActionEvent',
        ];
    }
}
