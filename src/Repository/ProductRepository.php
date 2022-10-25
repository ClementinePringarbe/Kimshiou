<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //* DQL : Doctrine Query Language
    // On veut créer une méthode qui nous renvoie tous les produits triés par leurs noms par ordre alphabétique
    public function findAllProductsByNameAscDQL()
    {
        $entityManager = $this->getEntityManager();

        // En DQL, on ne fait pas de requête sur les tables directement, mais sur les entités Doctrine
        //?https://www.doctrine-project.org/projects/doctrine-orm/en/2.11/reference/dql-doctrine-query-language.html#dql-select-examples
        // On va donc utiliser le FQCN des entités à l'intérieur de la requête DQL
        // En SQL :  SELECT * FROM product ORDER BY name ASC
        $query = $entityManager->createQuery('
            SELECT p FROM App\Entity\Product p ORDER BY p.name ASC
        ');

        return $query->getResult();
    }

    //* Query Builder
    
    /**
     * On veut créer une méthode qui nous renvoie tous les produits triés par leurs noms par ordre alphabétique
     *
     * @return mixed
     */
    public function findAllProductsByNameAscQb()
    {
        // Le querybuilder sait déjà qu'on va requêter sur l'entité Product
        // car nous sommes dans ProductRepository
        // Donc pas besoin de préciser le FQCN de l'entité à requêter
        // 'p' est juste l'alias de App\Entity\Product
        $results = $this->createQueryBuilder('p') 
            ->orderBy('p.name', 'ASC') // On trie sur la propriété creditOrder
            ->getQuery()
            ->getResult();

        return $results;
    }

//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
