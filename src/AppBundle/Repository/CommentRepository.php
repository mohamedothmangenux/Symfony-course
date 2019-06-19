<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    /**
     * @param Post $post
     *
     * @return PostComment[]
     */
    public function findAllRecentCommentsForPost($post)
    {
        return $this->createQueryBuilder('post_comments')
            ->andWhere('post_comments.post = :post')
            ->setParameter('post', $post)
            ->andWhere('post_comments.created_at > :recentDate')
            ->setParameter('recentDate', new \DateTime('-3 months'))
            ->getQuery()
            ->execute();
    }
}
