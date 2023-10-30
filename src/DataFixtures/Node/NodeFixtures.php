<?php

namespace App\DataFixtures\Node;

use App\DataFixtures\AppFixtures;
use App\Entity\Node;
use App\Model\Decoratable;
use App\Model\Reviewable;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

abstract class NodeFixtures extends AppFixtures
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $entity = $this->createEntity($data);

            $entity
                ->setTitle(is_string($data['title']) ? $data['title'] : '')
                ->setSlug(is_string($data['slug']) ? $data['slug'] : '')
                ->setContent(is_string($data['content']) ? $data['content'] : '')
                ->setDraft(is_bool($data['draft']) ? $data['draft'] : false)
                ->setActif(is_bool($data['actif']) ? $data['actif'] : true)
                ->setSticky(is_bool($data['sticky']) ? $data['sticky'] : true)
                ->setCommentable(is_bool($data['commentable']) ? $data['commentable'] : true);

            if (array_key_exists('publishedAt', $data) && $data['publishedAt'] instanceof DateTimeImmutable) {
                $entity->setPublishedAt($data['publishedAt']);
            }

            if ($entity instanceof Reviewable) {
                $entity->setReviewed(is_bool($data['reviewed']) ? $data['reviewed'] : true);
            }

            if ($entity instanceof Decoratable) {
                $entity->setDecorated(is_bool($data['decorated']) ? $data['decorated'] : true);
            }

            if (is_string($data['slug'])) {
                $this->setReference($data['slug'], $entity);
            }

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * @param array<string, mixed> $data
     */
    protected abstract function createEntity(array $data): Node;

    /**
     * @return array<array<string, array<string, string>|bool|string|DateTimeImmutable|null>>
     */
    protected abstract function getData(): array;
}