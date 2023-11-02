<?php

namespace App\Workflow\Place;

enum PostTransition: string
{
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
            self::DRAFT => 'Save as draft',
            self::WRITE => 'Save',
            self::DECORATE => 'Decorate',
            self::REVIEW => 'Review',
            self::PUBLISH => 'Publish',
            self::UNPUBLISH => 'Unpublish',
        };
    }

    public function getActionIcon(): ?string
    {
        return match ($this) {
            self::DECORATE => 'fa fa-camera',
            self::REVIEW => 'fa fa-wrench',
            self::PUBLISH => 'fa fa-check',
            self::UNPUBLISH => 'fa fa-xmark',
            default => null,
        };
    }

    public function getCssClass(): ?string
    {
        return match ($this) {
            self::UNPUBLISH => 'text-danger',
            default => '',
        };
    }
}
