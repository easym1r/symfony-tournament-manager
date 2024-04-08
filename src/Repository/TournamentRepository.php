<?php

namespace App\Repository;

use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournament>
 *
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    /**
     * Удаление записи из таблицы
     *
     * @param Tournament $tournament - Объект записи из таблицы
     *
     * @return void
     */
    public function delete(Tournament $tournament): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($tournament);
        $entityManager->flush();
    }

    /**
     * Добавление записи в таблицу
     *
     * @param string $tournamentName - Название команды, поле 'name' в таблице
     *
     * @return int - id зарегистрированного турнира
     */
    public function add(string $tournamentName): int
    {
        $tournament = new Tournament();
        $tournament->setName($tournamentName);
        $tournament->setDateRegistration(new \DateTime()); // FIXME Разобраться почему при указании в БД для этого столбца DEFAULT CURRENT_TIMESTAMP - не работает

        $entityManager = $this->getEntityManager();
        $entityManager->persist($tournament);
        $entityManager->flush();

        return $tournament->getId();
    }

    //    /**
    //     * @return Tournament[] Returns an array of Tournament objects
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

    //    public function findOneBySomeField($value): ?Tournament
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
