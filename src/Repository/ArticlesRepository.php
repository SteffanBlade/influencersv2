<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticlesRepository extends ServiceEntityRepository {


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }


    /**
     * @return Articles[]
     */
    public function findArticleByAuthorId($id) {
        $entityManager = $this->getEntityManager();


        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder('article');
        $qb->select('articles')
            ->from('App:Articles','articles')
            ->where('articles.author = :inputId')
            ->setParameter('inputId',$id);


        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findArticleByTag($tag) {

        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder('article');
        $qb->select('articles')
            ->from('App:Articles','articles')
            ->where($qb->expr()->like('articles.tags', ':inputTag'))
            ->setParameter('inputTag','%' . $tag . '%');

        $query = $qb->getQuery();
        return $query->getResult();
    }


}