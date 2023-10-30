<?php

namespace App\Repository\Node;

use App\Entity\Node\Post;
use App\Repository\NodeRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\Query\QueryException;

/**
 * @extends NodeRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends NodeRepository
{
    /**
     * @param Criteria|null $criteria
     * @return Post[]
     * @throws Exception
     * @throws QueryException
     */
    public function findMain(Criteria $criteria = null): array
    {
        $query = $this->getQueryEntityPublish('p')
            ->andWhere('p.sticky = 1')
            ->orderBy('p.publishedAt', Criteria::DESC)
            ->setMaxResults(2);

        if (null !== $criteria) {
            $query->addCriteria($criteria);
        }

        $data = $query->getQuery()->getResult();

        if (!is_array($data)) {
           throw new Exception('Error');
        }

        return $data;
    }

    /**
     * @param Criteria|null $criteria
     * @return Post[]
     * @throws Exception
     * @throws QueryException
     */
    public function findLastSticky(?Criteria $criteria = null): array
    {
        $query = $this->getQueryEntityPublish('p')
            ->andWhere('p.sticky = 1')
            ->orderBy('p.publishedAt', Criteria::DESC)
            ->setMaxResults(2);

        if (null !== $criteria) {
            $query->addCriteria($criteria);
        }

        $data = $query->getQuery()->getResult();

        if (!is_array($data)) {
            throw new Exception('Error');
        }

        return $data;
    }

    protected function getNodeClass(): string
    {
        return Post::class;
    }
}
