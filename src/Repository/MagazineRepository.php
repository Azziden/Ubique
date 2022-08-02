<?php

namespace App\Repository;

use App\Entity\Magazine;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Magazine>
 *
 * @method Magazine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Magazine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Magazine[]    findAll()
 * @method Magazine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MagazineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Magazine::class);
    }

    /**
     * Recherche les magazines en fonction du formulaire
     */
    public function search($mots, ?User $user){
        $query = $this->createQueryBuilder('m');
        if($mots != null){
            $query->where('m.code_affaire LIKE :mots')
                ->orWhere('m.code_affaire_en_clair LIKE :mots')
                ->orderBy('m.id', 'DESC')
                ->setParameter('mots',  "%" .$mots . "%");
        }

        if ($user) {
            $query = $query
                ->innerJoin('m.titre', 't')
                ->innerJoin('t.titreMemberships', 'tm')
                ->innerJoin('tm.user', 'tmu')
                ->andWhere('tmu.id = :user_id')
                ->setParameter('user_id', $user->getId());

        }

        return $query->getQuery()->getResult();


    }


    public function add(Magazine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Magazine $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getForExport()
    {
        $query = $this->createQueryBuilder('m')
            ->select('m.code_affaire, m.code_affaire_en_clair, m.date_de_bouclage, m.date_de_parution, m.titre_en_clair, m.nb_de_page_redactionnelle, m.chiffre_affaire')
            ->getQuery()
            ->getResult();

        return $query;

    }


//    /**
//     * @return Magazine[] Returns an array of Magazine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Magazine
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}