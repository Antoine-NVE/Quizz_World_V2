<?php

namespace App\Repository;

use App\Entity\Questions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Questions>
 *
 * @method Questions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questions[]    findAll()
 * @method Questions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questions::class);
    }

    public function findWithPropositions($id): ?Questions
    {
        return $this->createQueryBuilder('q')
            ->select('q', 'p')
            ->join('q.propositions', 'p')
            ->where('q.id = :id')
            ->setParameter('id', $id)
            ->orderBy('p.id')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findWithPropositionsBySlugDifficultyNumberAndUser($slug, $difficulty, $number, $user): ?Questions
    {
        return $this->createQueryBuilder('q')
            ->select('q', 'p')
            ->join('q.propositions', 'p')
            ->join('q.questionnaire', 'qn')
            ->join('qn.category', 'c')
            ->where('c.slug = :slug')
            ->andWhere('c.user = :user')
            ->andWhere('qn.difficulty = :difficulty')
            ->setParameter('slug', $slug)
            ->setParameter('difficulty', $difficulty)
            ->setParameter('user', $user)
            ->setFirstResult(($number - 1) * 4)
            ->setMaxResults(4)
            ->orderBy('p.id')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByIdAndUser($id, $user): ?Questions
    {
        return $this->createQueryBuilder('q')
            ->select('q')
            ->join('q.questionnaire', 'qn')
            ->join('qn.category', 'c')
            ->where('q.id = :id')
            ->andWhere('c.user = :user')
            ->setParameter('id', $id)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Questions[] Returns an array of Questions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Questions
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
