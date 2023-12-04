<?php

namespace App\Workflow\MarkingStore;

use App\Entity\Node\Post;
use App\Model\Decoratable;
use App\Model\Draftable;
use App\Model\Publiable;
use App\Model\Reviewable;
use App\Workflow\Place\PostPlace;
use DateTimeImmutable;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;

class NodePostMarkingStore implements MarkingStoreInterface
{
    /**
     * @param Post $subject
     * @return Marking
     */
    public function getMarking(object $subject): Marking
    {
        $marking = new Marking;

        $marking->mark(PostPlace::INITIALISATION->value);

        if (null !== $subject->getTitle() && null !== $subject->getSlug()) {
            $marking->unmark(PostPlace::INITIALISATION->value);
            $marking->mark(PostPlace::IN_DRAFT->value);
        }

        if (!$subject->isDraft()) {
            $marking->unmark(PostPlace::IN_DRAFT->value);
            $marking->mark(PostPlace::WROTE->value);
        }

        if ($subject->isReviewed()) {
            $marking->mark(PostPlace::REVIEWED->value);
        }

        if ($subject->isDecorated()) {
            $marking->mark(PostPlace::DECORATED->value);
        }

        if ($subject->isReviewed() && $subject->isDecorated()) {
            $marking->unmark(PostPlace::WROTE->value);
        }

        if ($subject->isPublished()) {
            $marking->mark(PostPlace::PUBLISHED->value);
        }

        return $marking;
    }

    /**
     * @param Post $subject
     * @param Marking $marking
     * @param array<mixed> $context
     * @return void
     */
    public function setMarking(object $subject, Marking $marking, array $context = [])
    {
        foreach (array_keys($marking->getPlaces()) as $place) {
            $placeEnum = PostPlace::from($place);

            switch ($placeEnum) {
                case PostPlace::IN_DRAFT :
                    if ($subject instanceof Draftable) {
                        $subject->setDraft(true);
                    }
                    break;
                case PostPlace::WROTE :
                    if ($subject instanceof Draftable) {
                        $subject->setDraft(false);
                    }
                    break;
                case PostPlace::REVIEWED :
                    if ($subject instanceof Reviewable) {
                        $subject->setReviewed(true);
                    }
                    break;
                case PostPlace::DECORATED :
                    if ($subject instanceof Decoratable) {
                        $subject->setDecorated(true);
                    }
                    break;
                case PostPlace::PUBLISHED :
                    if ($subject instanceof Publiable) {
                        $subject->setPublishedAt($subject->getPublishedAt() ?? new DateTimeImmutable());
                    }
                    break;
                case PostPlace::UNPUBLISHED :
                    if ($subject instanceof Publiable) {
                        $subject->setPublishedAt(null);
                    }
                    break;
            }
        }
    }
}