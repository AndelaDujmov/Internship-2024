<?php

namespace App\Repository;

use App\Entity\RequestForAL;
use App\Entity\User;
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

    public function findById(string $id): RequestForAL|null {
        return $this->find($id);
    }

    public function create(RequestForAL $requestForAL){
        $em = $this->getEntityManager();
        $em->persist($requestForAL);
        $em->flush();
    }

    public function update(RequestForAL $requestForAL){
        $em = $this->getEntityManager();
        $em->flush();
    }

    public function delete(RequestForAL $requestForAL){
        $em = $this->getEntityManager();
        $em->remove($requestForAL);
        $em->flush();
    }

    public function findByUser(string $id)
    {
        return $this->createQueryBuilder('r')
            ->where('r.worker = :user')
            ->setParameter('user', $id)
            ->orderBy('CASE 
                WHEN r.status = :pending THEN 1 
                WHEN r.status = :accepted THEN 2 
                WHEN r.status = :rejected THEN 3 
                ELSE 4 
            END', 'ASC')
            ->addOrderBy('r.end', 'DESC')
            ->addOrderBy('r.start', 'DESC')
            ->setParameter('pending', \App\Enum\Status::PENDING)
            ->setParameter('accepted', \App\Enum\Status::COMPLETED)
            ->setParameter('rejected', \App\Enum\Status::CANCELLED)
            ->getQuery()
            ->getResult();
    }
    
    public function findByUsers(array $ids)
    {
        return $this->createQueryBuilder('r')
            ->where('r.worker IN (:ids)')
            ->setParameter('ids', $ids)
            ->orderBy('r.end', 'DESC')
            ->addOrderBy('r.start', 'DESC')
            ->getQuery()
            ->getResult();
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
