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
 * Class AuthorRepository
 * @package MSBios\ModelBundle\Repository
 */
class AuthorRepository extends EntityRepository
{
    /**
     * Find the first post
     * @return mixed
     */
    public function findFirst()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getQueryBuilder()
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(1);

        return $queryBuilder->getQuery()
            ->getSingleResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        return $this->createQueryBuilder('a');
    }
}