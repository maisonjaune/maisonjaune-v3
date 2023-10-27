<?php

namespace App\DataFixtures\Node;

use App\DataFixtures\AppFixtures;
use App\Entity\Node\Category;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends AppFixtures
{
    public function load(ObjectManager $manager)
    {
        $news = (new Category())
            ->setName('News')
            ->setSlug('news')
            ->setShortname('News');

        $manager->persist($news);
        $this->setReference('News', $news);

        $mercato = (new Category())
            ->setName('Mercato')
            ->setSlug('mercato')
            ->setShortname('Mercato');

        $manager->persist($mercato);
        $this->setReference('Mercato', $mercato);

        $poadcast = (new Category())
            ->setName('Poadcast')
            ->setSlug('poadcast')
            ->setShortname('Poadcast');

        $manager->persist($poadcast);
        $this->setReference('Poadcast', $poadcast);

        $jeunes = (new Category())
            ->setName('Jeunes')
            ->setSlug('jeunes')
            ->setShortname('Jeunes');

        $manager->persist($jeunes);
        $this->setReference('Jeunes', $jeunes);

        $interview = (new Category())
            ->setName('Interview')
            ->setSlug('interview')
            ->setShortname('Interview');

        $manager->persist($interview);
        $this->setReference('Interview', $interview);

        $manager->flush();
    }
}