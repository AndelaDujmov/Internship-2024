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

    public function addLeaders(Team $team, ?User $teamLeader, ?User $projectLeader) : void {
        $teamLeaders = new TeamLeaders();
        $teamLeaders->setTeam($team);
        $teamLeaders->setTeamLead($teamLeader);
        $teamLeaders->setProjectLeader($projectLeader);
    }

    public function addLeader(TeamLeaders $teamLeaders, ?User $leader) : void {
        if ($leader->hasRole(\App\Enum\Role::PROJECTLEADER->value)){
            $teamLeaders->setProjectLeader($leader);
        }else {
            $teamLeaders->setTeamLead($leader);
        }
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
