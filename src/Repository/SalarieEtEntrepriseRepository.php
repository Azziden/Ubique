<?php

namespace App\Repository;

use App\Entity\SalarieEtEntreprise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalarieEtEntreprise>
 *
 * @method SalarieEtEntreprise|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalarieEtEntreprise|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalarieEtEntreprise[]    findAll()
 * @method SalarieEtEntreprise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalarieEtEntrepriseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalarieEtEntreprise::class);
    }

    
    
    public function add(SalarieEtEntreprise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    

    public function remove(SalarieEtEntreprise $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SalarieEtEntreprise[] Returns an array of SalarieEtEntreprise objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SalarieEtEntreprise
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findAllMatching(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.nom_d_usage LIKE :query')
            ->leftJoin('u.redachef', 'r')
            ->andWhere('r.id is null')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findAllMatchingIcono(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.nom_d_usage LIKE :query')
            ->leftJoin('u.iconographique', 'i')
            ->andWhere('i.id is null')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

}
