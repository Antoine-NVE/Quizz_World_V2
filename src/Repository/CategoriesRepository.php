<?php

namespace App\Repository;

use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categories>
 *
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function findCompletesAndActives(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'u')
            ->join('c.user', 'u')
            // Sous-requête qui vérifie qu'il y a 30 questions dans la catégorie
            ->andWhere('(SELECT COUNT(q.id) FROM App\Entity\Questions q JOIN q.questionnaire qn2 WHERE qn2.category = c) = 30')
            ->andWhere('c.isActive = true')
            ->getQuery()
            ->getResult();
    }

    public function findCompletesAndActivesWithScores($user): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'qn', 's', 'u')
            ->join('c.questionnaires', 'qn')
            ->join('c.user', 'u')
            ->leftJoin('qn.scores', 's', 'WITH', 's.user = :user')
            // Sous-requête qui vérifie qu'il y a 30 questions dans la catégorie
            ->andWhere('(SELECT COUNT(q.id) FROM App\Entity\Questions q JOIN q.questionnaire qn2 WHERE qn2.category = c) = 30')
            ->andWhere('c.isActive = true')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findWithQuestionnaireAndScore($categorySlug, $difficulty, $user)
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'qn', 's')
            ->join('c.questionnaires', 'qn')
            ->join('qn.scores', 's', 'WITH', 's.user = :user')
            ->andWhere('c.slug = :categorySlug')
            ->andWhere('qn.difficulty = :difficulty')
            // Sous-requête qui vérifie qu'il y a 30 questions dans la catégorie
            ->andWhere('(SELECT COUNT(q.id) FROM App\Entity\Questions q JOIN q.questionnaire qn2 WHERE qn2.category = c) = 30')
            ->andWhere('c.isActive = true')
            ->setParameter('categorySlug', $categorySlug)
            ->setParameter('difficulty', $difficulty)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Categories[] Returns an array of Categories objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Categories
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
