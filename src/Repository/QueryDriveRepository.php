<?php

namespace App\Repository;

use App\Entity\QueryDrive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QueryDrive>
 *
 * @method QueryDrive|null find($id, $lockMode = null, $lockVersion = null)
 * @method QueryDrive|null findOneBy(array $criteria, array $orderBy = null)
 * @method QueryDrive[]    findAll()
 * @method QueryDrive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QueryDriveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QueryDrive::class);
    }

    public function save(QueryDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(QueryDrive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return QueryDrive[] Returns an array of QueryDrive objects
//     */
    public function findByContains($category): array
    {
        return $this->createQueryBuilder('q')
            ->containsAny('q.Category = :Category')
            ->setParameter('Category', $category)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?QueryDrive
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
