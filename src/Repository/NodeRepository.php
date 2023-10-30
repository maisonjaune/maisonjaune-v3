<?php

namespace App\Repository;

use App\Entity\Node;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template T of Node
 * @extends ServiceEntityRepository<T|Node>
 * @template-extends ServiceEntityRepository<T|Node>
 *
 * @method Node|null find($id, $lockMode = null, $lockVersion = null)
 * @method Node|null findOneBy(array $criteria, array $orderBy = null)
 * @method Node[]    findAll()
 * @method Node[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getNodeClass());
    }

    public function save(Node $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Node $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getQueryEntityPublish(string $alias): QueryBuilder
    {
        return $this->createQueryBuilder($alias)
            ->where("{$alias}.actif = 1")
            ->andWhere("{$alias}.draft = 0")
            ->andWhere("{$alias}.publishedAt < :today")
            ->setParameter('today', new DateTime());
    }

    public function countAll(): int
    {
        return (int) $this->createQueryBuilder('n')
            ->select('COUNT(n)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return class-string<T|Node>
     */
    protected function getNodeClass(): string
    {
        return Node::class;
    }
}
