<?php

namespace App\Repository;

use App\Entity\Categories;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findCompletesAndActivesWithScores(int $page, int $limit, string $sort, string $order, string $search, ?Users $user = null): array
    {
        // On multiplie par 3 car il y a 3 questionnaires par catégorie
        $limit = $limit * 3;

        $query = $this->createQueryBuilder('c')
            ->select('c', 'qn', 's', 'u')
            ->join('c.user', 'u')
            ->join('c.questionnaires', 'qn')
            ->leftJoin('qn.scores', 's', 'WITH', 's.user = :user')
            // Sous-requête qui vérifie qu'il y a 30 questions dans la catégorie
            ->andWhere('(SELECT COUNT(q.id) FROM App\Entity\Questions q JOIN q.questionnaire qn2 WHERE qn2.category = c) = 30')
            ->andWhere('c.isActive = true')
            ->orderBy($sort, $order)
            ->andWhere('c.title LIKE :search OR u.pseudo LIKE :search')
            ->setParameter('user', $user)
            ->setParameter('search', '%' . $search . '%')
            ->setFirstResult(($page * $limit) - ($limit))
            ->setMaxResults($limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        // A l'inverse on divise par 3 car le count() ne compte que les catégories
        $limit = $limit / 3;

        $pages = (int)ceil($paginator->count() / $limit);

        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
        $result['sort'] = $sort;
        $result['order'] = $order;
        $result['search'] = $search;

        return $result;
    }

    public function findOneOrNullWithQuestionnaireQuestionsPropositionsAndScore(string $slug, string $difficulty, Users $user): ?Categories
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'qn', 'q', 'p', 's')
            ->join('c.questionnaires', 'qn')
            ->join('qn.questions', 'q')
            ->join('q.propositions', 'p')
            ->leftJoin('qn.scores', 's', 'WITH', 's.user = :user')
            ->andWhere('(SELECT COUNT(q2.id) FROM App\Entity\Questions q2 JOIN q2.questionnaire qn2 WHERE qn2.category = c) = 30') // 30 questions
            ->andWhere('c.isActive = true')
            ->andWhere('c.slug = :slug')
            ->andWhere('qn.difficulty = :difficulty')
            ->setParameter('slug', $slug)
            ->setParameter('difficulty', $difficulty)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllWithUserAndNumberOfQuestions(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'u', 'COUNT(q.id)')
            ->join('c.user', 'u')
            ->join('c.questionnaires', 'qn')
            ->leftJoin('qn.questions', 'q')
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
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
