<?php

namespace App\Workflow\Place;

enum PostTransition: string
{
    case INITIALISATION = 'Initialisation';

    case DRAFT = 'Draft';

    case WRITE = 'Write';

    case DECORATE = 'Decorate';

    case REVIEW = 'Review';

    case PUBLISH = 'Publish';

    case UNPUBLISH = 'Unpublish';

    /**
     * @return PostTransition[]
     */
    public static function getIndexActions(): array
    {
        return [
            self::WRITE,
            self::DECORATE,
            self::REVIEW,
            self::PUBLISH,
            self::UNPUBLISH,
        ];
    }

    public function getActionName(): string
    {
        return $this->value;
    }

    public function getActionLabel(): string
    {
        return match ($this) {
            self::INITIALISATION => 'Create',
            self::DRAFT => 'Draft',
            self::WRITE => 'Write',
            self::DECORATE => 'Decorate',
            self::REVIEW => 'Review',
            self::PUBLISH => 'Publish',
            self::UNPUBLISH => 'Unpublish',
        };
    }

    public function getActionIcon(): ?string
    {
        return match ($this) {
            self::INITIALISATION => 'fa fa-plus',
            self::DRAFT, self::WRITE => 'fa fa-pen',
            self::DECORATE => 'fa fa-camera',
            self::REVIEW => 'fa fa-wrench',
            self::PUBLISH => 'fa fa-check',
            self::UNPUBLISH => 'fa fa-xmark',
        };
    }

    public function getCssClass(): ?string
    {
        return match ($this) {
            self::UNPUBLISH => 'text-danger',
            default => '',
        };
    }

    public function getAdminView(): string
    {
        return match ($this) {
            self::INITIALISATION, self::DRAFT => strtolower(self::WRITE->value),
            default => strtolower($this->value),
        };
    }

    /**
     * @return PostTransition[]
     */
    public static function forRedaction(): array
    {
        return [
            self::INITIALISATION,
            self::DRAFT,
            self::WRITE,
        ];
    }
}
