<?php

namespace App\DataFixtures\Node\Brief;

use App\DataFixtures\AppFixtures;
use App\DataFixtures\Node\CategoryFixtures;
use App\DataFixtures\Node\NodeFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Node;
use App\Entity\Node\Brief;
use App\Entity\Node\Category;
use App\Entity\User;
use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BriefNewsFixtures extends NodeFixtures implements DependentFixtureInterface
{
    protected function createEntity(array $data): Node
    {
        $entity = new Brief();

        $category = $this->getReference('News');

        if ($category instanceof Category) {
            $entity->addCategory($category);
        }

        if (is_string($data['author'])) {
            $author = $this->getReference($data['author']);

            if ($author instanceof User) {
                $entity->setAuthor($author);
            }
        }

        return $entity;
    }

    protected function getData(): array
    {
        return [
            [
                'author' => 'redacteur01',
                'title' => 'Brève News 01',
                'slug' => 'breve-news-01',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P3M15D")),
            ],
            [
                'author' => 'redacteur02',
                'title' => 'Brève News 02',
                'slug' => 'breve-news-02',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P3M5D")),
            ],
            [
                'author' => 'redacteur03',
                'title' => 'Brève News 03',
                'slug' => 'breve-news-03',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P2M15D")),
            ],
            [
                'author' => 'redacteur01',
                'title' => 'Brève News 04',
                'slug' => 'breve-news-04',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P2M5D")),
            ],
            [
                'author' => 'redacteur01',
                'title' => 'Brève News 05',
                'slug' => 'breve-news-05',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P1M15D")),
            ],
            [
                'author' => 'redacteur01',
                'title' => 'Brève News 06',
                'slug' => 'breve-news-06',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P1M5D")),
            ],
            [
                'author' => 'redacteur01',
                'title' => 'Brève News 07',
                'slug' => 'breve-news-07',
                'content' => $this->parseEditorJs([
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Quapropter a natura mihi videtur potius quam ab indigentia orta amicitia, applicatione magis animi cum quodam sensu amandi quam cogitatione quantum illa res."
                        ]
                    ],
                    [
                        "type" => "paragraph",
                        "data" => [
                            "text" => "Ideo urbs venerabilis post superbas efferatarum gentium cervices oppressas latasque leges fundamenta libertatis et retinacula sempiterna velut."
                        ]
                    ]
                ]),
                'draft' => false,
                'actif' => true,
                'sticky' => true,
                'commentable' => true,
                'publishedAt' => (new DateTimeImmutable())->sub(new DateInterval("P15D")),
            ],
        ];
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}