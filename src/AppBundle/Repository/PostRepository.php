<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    /**
     * @return Post[]
     */
    public function findAllPublished()
    {
        return $this->createQueryBuilder('post')
            ->andWhere('post.status = :stat')
            ->setParameter('stat', true)
            ->orderBy('post.id', 'DESC')
            ->setMaxResults(100000000)
            ->getQuery()
            ->execute();
    }
}
