<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MainController extends AbstractController
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    #[Route('/', name: 'app_main')]
    public function index(CategoriesRepository $categoriesRepository, Request $request): Response
    {
        // Eléments de l'URL pour la pagination et le tri
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);
        $sort = $request->query->getString('sort', 'c.createdAt');
        $order = $request->query->getString('order', 'desc');
        $search = $request->query->getString('search');

        // Validations des différentes données
        $pageViolations = $this->validator->validate($page, [
            new Positive()
        ]);
        $limitViolations = $this->validator->validate($limit, [
            new Positive()
        ]);
        $sortViolations = $this->validator->validate($sort, [
            new Choice([
                'c.createdAt',
                'c.title',
                'u.pseudo'
            ])
        ]);
        $orderViolations = $this->validator->validate($order, [
            new Choice([
                'asc',
                'desc'
            ])
        ]);

        // Renvoi d'une erreur
        if (
            count($pageViolations) +
            count($limitViolations) +
            count($sortViolations) +
            count($orderViolations) > 0
        ) {
            throw new \Exception('Données de pagination et/ou de tri incorrectes.');
        }

        // Récupération de toutes les catégories concernées par les paramètres ci-dessus
        $categories = $categoriesRepository->findCompletesAndActivesWithScores($page, $limit, $sort, $order, $search, $this->getUser());

        // Evite certaines erreurs dans le cas où l'on n'a pas de résultat
        if ($categories['pages'] === 0) {
            $categories['pages'] = 1;
        }

        // On supprime les potentiels scores stockés en session
        $session = $request->getSession();
        $session->remove('answers');

        return $this->render('main/index.html.twig', compact('categories'));
    }
}
