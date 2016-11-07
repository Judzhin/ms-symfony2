<?php
/**
 * @access protected
 * @author Judzhin Miles <info[woof-woof]msbios.com>
 */
namespace MSBios\ModelBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PostRepository
 * @package MSBios\ModelBundle\Repository
 */
class PostRepository extends EntityRepository
{
    /**
     * @param $maxResults
     * @return array
     */
    public function findLatest($maxResults)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getQueryBuilder()
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($maxResults);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find the first post
     * @return mixed
     */
    public function findFirst()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getQueryBuilder()
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->createQueryBuilder('p');

        return $queryBuilder;
    }
}