<?php

namespace App\Service\Statistics\Counter;

use App\Repository\UserRepository;
use App\Service\Statistics\BlockStatisticInterface;

class UserCounterStatistic implements BlockStatisticInterface
{
    public function __construct(
        private UserRepository $userRepository,
    )
    {
    }

    public function getTitle(): string
    {
        return 'Users';
    }

    public function getStat(): mixed
    {
        return $this->userRepository->countAll();
    }

    public function getIconClass(): string
    {
        return 'fa-users';
    }

    public function getBackgroundColor(): string
    {
        return 'text-bg-primary';
    }

    public function getTextColor(): string
    {
        return 'text-white';
    }
}