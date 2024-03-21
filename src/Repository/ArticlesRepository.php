<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

   /**
    * Limite le nombre de résultats d'articles.
    * @param int $limit
    * @return Articles[] Returns an array of Articles objects
    */
   public function findLimit($limit, $offset): array
   {
        if (empty($offset)) {
            $offset = 0;
        }
       return $this->createQueryBuilder('a')
           ->setMaxResults(max(1,min($limit, 25)))
           ->setFirstResult(max(0, $offset))
           ->getQuery()
           ->getResult()
       ;
   }

    /**
     * Permet de rechercher des articles en fonction de leur nom et rayon.
     * Lorsqu'un paramètre est vide, il n'est pas pris en compte, pour faciliter l'utilisation.
     * @param ?string   $nom
     * @param ?Rayons   $rayon
     * @param ?int      $limit
     * @param ?int      $offset
    * @return Articles[] Returns an array of Articles objects
    */
    public function findSearch($nom, $rayon, $limit, $offset): array
    {
        $query = $this->createQueryBuilder('a');

        if (empty($limit)) {
            $limit = 25;
        }
        if (empty($offset)) {
            $offset = 0;
        }

        if (!empty($nom)) {
            $query = $query
            ->andWhere('a.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%');
        }
        
        if (!empty($rayon)) {
            $query = $query
            ->andWhere('a.fk_rayons = :rayon')
            ->setParameter('rayon', $rayon);
        }

        $query = $query->setMaxResults(max(1,min($limit, 25)))->setFirstResult(max(0, $offset));

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Articles[] Returns an array of Articles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Articles
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
