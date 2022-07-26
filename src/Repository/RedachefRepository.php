<?php

namespace App\Repository;

use App\Entity\Redachef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Redachef>
 *
 * @method Redachef|null find($id, $lockMode = null, $lockVersion = null)
 * @method Redachef|null findOneBy(array $criteria, array $orderBy = null)
 * @method Redachef[]    findAll()
 * @method Redachef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RedachefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Redachef::class);
    }

    public function add(Redachef $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Redachef $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getForExport() {
        return $this->createQueryBuilder('r')
            //"Code Affaire", "Nom d'usage", "Article", "Signe", "Nb de feuillet", "Forfait", "Prix au feuillet", "Montant", "Montant total brut", "Montant charge"
            ->select('m.code_affaire, see.nom_d_usage, r.article, r.signe, r.nb_de_feuillet, r.forfait, r.prix_au_feuillet, r.montant, r.montant_total_brut, r.montant_charge')
            ->innerJoin('r.magazine', 'm')
            ->innerJoin('r.salarie_et_entreprise', 'see')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Redachef[] Returns an array of Redachef objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Redachef
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}