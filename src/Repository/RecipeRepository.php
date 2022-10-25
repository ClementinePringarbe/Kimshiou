<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function add(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //* DQL : Doctrine Query Language
    // On veut créer une méthode qui nous renvoie toutes les recettes triées par leurs noms par ordre alphabétique
    public function findAllRecipesByNameAscDQL()
    {
        $entityManager = $this->getEntityManager();

        // En DQL, on ne fait pas de requête sur les tables directement, mais sur les entités Doctrine
        //?https://www.doctrine-project.org/projects/doctrine-orm/en/2.11/reference/dql-doctrine-query-language.html#dql-select-examples
        // On va donc utiliser le FQCN des entités à l'intérieur de la requête DQL
        // En SQL :  SELECT * FROM recipe ORDER BY name ASC
        $query = $entityManager->createQuery('
            SELECT r FROM App\Entity\Recipe r ORDER BY r.name ASC
        ');

        return $query->getResult();
    }

    //* Query Builder
    
    /**
     * On veut créer une méthode qui nous renvoie toutes les recettes triées par leurs noms par ordre alphabétique
     *
     * @return mixed
     */
    public function findAllRecipesByNameAscQb()
    {
        // Le querybuilder sait déjà qu'on va requêter sur l'entité Recipe
        // car nous sommes dans RecipeRepository
        // Donc pas besoin de préciser le FQCN de l'entité à requêter
        // 'r' est juste l'alias de App\Entity\Recipe
        $results = $this->createQueryBuilder('r') 
            ->orderBy('r.name', 'ASC') // On trie sur la propriété creditOrder
            ->getQuery()
            ->getResult();

        return $results;
    }

//    /**
//     * @return Recipe[] Returns an array of Recipe objects
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

//    public function findOneBySomeField($value): ?Recipe
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
