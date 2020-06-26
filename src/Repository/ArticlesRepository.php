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
    public function testQuery(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p.articlesVotes
            FROM App\Entity\Articles p
            where p.articlesVotes > 5'
        );
        return $query->getResult();

    }
}