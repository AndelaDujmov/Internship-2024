<?php

namespace App\Repository;

use App\Entity\Team;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<Team>
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    public function create(Team $team): void {
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->flush();
    }

    public function update(Team $team): void {
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->flush();
    }

    public function remove(Team $team): void {
        $em = $this->getEntityManager();
        $em->remove($team);
        $em->flush();
    }

    public function showAllWorkers(Team $team): array {
        return $team->getMembers()->toArray();
    }

    public function addWorkerToTeam(User $worker, Team $team) : void {
        $team->addMember($worker);
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->persist($worker);
        $em->flush();
    }

    public function removeWorkerFromTeam(User $worker, Team $team) : void {
        $team->removeMember($worker);
        $em = $this->getEntityManager();
        $em->persist($team);
        $em->persist($worker);
        $em->flush();
    }

    public function delete(Team $team) : void {
        $em = $this->getEntityManager();
        $em->remove($team);
        $em->flush();
    }

    //    /**
    //     * @return Team[] Returns an array of Team objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Team
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
