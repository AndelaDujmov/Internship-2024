<?php

namespace App\Repository;

use App\Entity\RequestForAL;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RequestForAL>
 */
class RequestForALRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RequestForAL::class);
    }

    public function create(RequestForAL $requestForAL){
        $em = $this->getEntityManager();
        $em->persist($requestForAL);
        $em->flush();
    }

    public function update(RequestForAL $requestForAL){
        $em = $this->getEntityManager();
        $em->persist($requestForAL);
        $em->flush();
    }

    public function delete(RequestForAL $requestForAL){
        $em = $this->getEntityManager();
        $em->remove($requestForAL);
        $em->flush();
    }

    //    /**
    //     * @return RequestForAL[] Returns an array of RequestForAL objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RequestForAL
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
