<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Notification>
 */
class NotificationRepository extends ServiceEntityRepository
{
    private $userRepository;

    public function __construct(ManagerRegistry $registry, UserRepository $userRepository)
    {
        parent::__construct($registry, Notification::class);
        $this->userRepository = $userRepository;
    }

    public function getManager() : EntityManagerInterface {
        return $this->getEntityManager();
    }

    public function add(Notification $notification): void {
        $this->_em->persist($notification);
        $this->_em->flush();
        
    }

    public function getAllByUser(User $user) : array {
        return $this->findBy(["user"=> $user->getId()]);
    }

//    /**
//     * @return Notification[] Returns an array of Notification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Notification
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
