<?php

namespace App\Repository;

use App\Entity\Iconographique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Iconographique>
 *
 * @method Iconographique|null find($id, $lockMode = null, $lockVersion = null)
 * @method Iconographique|null findOneBy(array $criteria, array $orderBy = null)
 * @method Iconographique[]    findAll()
 * @method Iconographique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IconographiqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iconographique::class);
    }

    public function add(Iconographique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Iconographique $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getForExport($date) {
        $query = $this->createQueryBuilder('i')
            ->select('m.code_affaire, see.nom_d_usage, m.date_de_parution, i.article, i.nb_photo, i.prix_photo, i.montant')
            ->innerJoin('i.magazine', 'm')
            ->innerJoin('i.salarie_et_entreprise', 'see');

        if ($date !== null) {
            $query = $query
                ->where('m.date_de_parution LIKE :date')
                ->setParameter("date", $date);
        }

        return $query
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Iconographique[] Returns an array of Iconographique objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Iconographique
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}