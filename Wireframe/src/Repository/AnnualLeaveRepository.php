<?php

namespace App\Repository;

use App\Entity\AnnualLeave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnnualLeave>
 */
class AnnualLeaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnualLeave::class);
    }

    public function create(AnnualLeave $annualLeave): void {
        $em = $this->getEntityManager();
        $em->persist($annualLeave);
        $em->flush();
    }

    public function update(AnnualLeave $annualLeave): void {
        $em = $this->getEntityManager();
        $em->persist($annualLeave);
        $em->flush();
    }

    public function remove(AnnualLeave $annualLeave): void {
        $em = $this->getEntityManager();
        $em->remove($annualLeave);
        $em->flush();
    }

//    /**
//     * @return AnnualLeave[] Returns an array of AnnualLeave objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnnualLeave
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
