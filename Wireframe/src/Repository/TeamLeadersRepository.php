<?php

namespace App\Repository;

use App\Entity\Team;
use App\Entity\TeamLeaders;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamLeaders>
 */
class TeamLeadersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamLeaders::class);
    }

    public function showLeaders(Team $team) : array {
        return $this->findBy(['team' => $team->getId()]);
    }

    public function addLeaders(TeamLeaders $teamLeaders) : void {
       $em = $this->getEntityManager();
       $em->persist($teamLeaders);
       $em->flush();
    }

    public function deleteLeaders(Team $team) : void {
        $teamLeaders = $this->showLeaders($team);
        $em = $this->getEntityManager();

        foreach ($teamLeaders as $teamLeader) {
            $em->remove($teamLeader);
        }
        $em->flush();
    }
    
    //    /**
    //     * @return TeamLeaders[] Returns an array of TeamLeaders objects
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

    //    public function findOneBySomeField($value): ?TeamLeaders
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
