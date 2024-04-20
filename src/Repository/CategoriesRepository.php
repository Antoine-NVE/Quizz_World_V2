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

    // Récupère toutes les catégories de l'accueil, avec les data pour la pagination
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

    // Récupère une catégorie avec tous les éléments, pour le QuizzController
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

    // Récupère toutes les catégories pour la liste de la page admin
    public function findAllWithQuestionnairesAndQuestionsAndUser(): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'qn', 'q', 'u')
            ->join('c.questionnaires', 'qn')
            ->leftJoin('qn.questions', 'q')
            ->join('c.user', 'u')
            ->getQuery()
            ->getResult();
    }

    // Récupère le nombre de catégories affichés pour l'accueil de l'admin
    public function countCompletedAndActives(): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('(SELECT COUNT(q2.id) FROM App\Entity\Questions q2 JOIN q2.questionnaire qn2 WHERE qn2.category = c) = 30')
            ->andWhere('c.isActive = true')
            ->getQuery()
            ->getSingleScalarResult();
    }

    // Récupère une catégorie avec questionnaires et questions pour l'édition du CategoriesController
    public function findOneOrNullWithQuestionnairesAndQuestions($id): ?Categories
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'qn', 'q')
            ->join('c.questionnaires', 'qn')
            ->leftJoin('qn.questions', 'q')
            ->where('c.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countCompletedAndActivesByUser(Users $user): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('(SELECT COUNT(q2.id) FROM App\Entity\Questions q2 JOIN q2.questionnaire qn2 WHERE qn2.category = c) = 30')
            ->andWhere('c.isActive = true')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
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
