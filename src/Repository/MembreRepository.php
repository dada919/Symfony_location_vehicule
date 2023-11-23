<?php

namespace App\Repository;

use App\Entity\Membre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MembreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Membre::class);
    }

    public function findByEmailOrUsername($login){

        $resultat =  $this->createQueryBuilder('m')
            ->andWhere('m.pseudo = :val OR m.email = :val')
            ->setParameter('val', $login)
            ->getQuery()
            ->getResult(); 

        if(empty($resultat) ){
            return null ;
        }
        return $resultat[0];       
    }
}