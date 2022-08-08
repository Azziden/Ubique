<?php

namespace App\Repository;

use App\Entity\Titre;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Titre>
 *
 * @method Titre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Titre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Titre[]    findAll()
 * @method Titre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Titre::class);
    }

    public function add(Titre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Titre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchTitre($mots, ?User $user){
        $query = $this->createQueryBuilder('t');
        if($mots != null){
            $query->where('t.titre_dans_tableau_direction LIKE :mots')
                ->orWhere('t.clients LIKE :mots')
                ->orderBy('t.id', 'DESC')
                ->setParameter('mots',  "%" .$mots . "%");
        }

        if ($user) {
            $query = $query
                ->innerJoin('t.titre_dans_tableau_direction', 't')
                ->innerJoin('t.titreMemberships', 'tm')
                ->innerJoin('tm.user', 'tmu')
                ->andWhere('tmu.id = :user_id')
                ->setParameter('user_id', $user->getId());

        }

        return $query->getQuery()->getResult();
    }



//    /**
//     * @return Titre[] Returns an array of Titre objects
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

//    public function findOneBySomeField($value): ?Titre
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}