<?php

namespace App\Workflow\MarkingStore;

use App\Entity\Node\Post;
use App\Workflow\Place\PostPlace;
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
        // TODO: Implement setMarking() method.
    }
}