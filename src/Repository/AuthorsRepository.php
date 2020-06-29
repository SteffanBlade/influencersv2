<?php

namespace App\Repository;

use App\Entity\Authors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class AuthorsRepository extends ServiceEntityRepository  {


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Authors::class);
    }


    /**
     * @return Authors[]
     */
    public function findAuthorByNameAndEmail(string $name,string $email):array {
        $entityManager = $this->getEntityManager();
//        $query = $entityManager->createQuery(
//            'SELECT author
//            FROM App\Entity\Authors author
//            WHERE author.name = \''.$name.'\' AND author.email = \''.$email.'\' ');
////        dd($query);
//        return $query->getResult();



        $entityManager = $this->getEntityManager();
       $qb = $entityManager->createQueryBuilder();
        $qb->select('author')
            ->from('App:Authors','author')
            ->where('author.name = :inputName')
            ->andWhere('author.email = :inputEmail')
            ->set('inputName',$name)
            ->set('inputEmail',$email);

        $query = $qb->getQuery();
        return $query->getResult();
    }

}