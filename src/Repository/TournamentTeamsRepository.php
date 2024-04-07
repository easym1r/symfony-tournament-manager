<?php

namespace App\Repository;

use App\Entity\TournamentTeams;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TournamentTeams>
 *
 * @method TournamentTeams|null find($id, $lockMode = null, $lockVersion = null)
 * @method TournamentTeams|null findOneBy(array $criteria, array $orderBy = null)
 * @method TournamentTeams[]    findAll()
 * @method TournamentTeams[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentTeamsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TournamentTeams::class);
    }

    //    /**
    //     * @return TournamentTeams[] Returns an array of TournamentTeams objects
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

    //    public function findOneBySomeField($value): ?TournamentTeams
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
