<?php

namespace App\Repository\Node;

use App\Entity\Node\Brief;
use App\Entity\Node\Category;
use App\Repository\NodeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Brief>
 *
 * @method Brief|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brief|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brief[]    findAll()
 * @method Brief[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BriefRepository extends NodeRepository
{
    public function findLast(): array
    {
        $query = $this->getQueryEntityPublish('b')
            ->orderBy('b.publishedAt', 'DESC')
            ->setMaxResults(4);

        return $query->getQuery()->getResult();
    }

    public function findLastByCategory(Category $category): array
    {
        $query = $this->getQueryEntityPublish('b')
            ->join('b.categories', 'c')
            ->andWhere('c IN (:categories)')
            ->setParameter('categories', [$category->getId()])
            ->orderBy('b.publishedAt', 'DESC')
            ->setMaxResults(10);

        return $query->getQuery()->getResult();
    }

    protected function getNodeClass(): string
    {
        return Brief::class;
    }
}
