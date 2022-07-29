<?php

namespace App\Repository;

use App\Entity\PigisteClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PigisteClient>
 *
 * @method PigisteClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method PigisteClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method PigisteClient[]    findAll()
 * @method PigisteClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PigisteClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PigisteClient::class);
    }

    public function add(PigisteClient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PigisteClient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getForExport($date) {
        $query = $this->createQueryBuilder('p')
            ->select('m.code_affaire, see.nom_d_usage, m.date_de_parution, p.article, p.signe, p.nb_de_feuillet, p.forfait, p.prix_au_feuillet, p.montant, p.montant_total_brut, p.montant_charge')
            ->innerJoin('p.magazine', 'm')
            ->innerJoin('p.salarie_et_entreprise', 'see');

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
//     * @return PigisteClient[] Returns an array of PigisteClient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PigisteClient
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
