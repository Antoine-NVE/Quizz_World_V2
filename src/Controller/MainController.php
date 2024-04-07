<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CategoriesRepository $categoriesRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 8);
        $sort = $request->query->getString('sort', 'createdAt');
        $order = $request->query->getString('order', 'desc');

        $categories = $categoriesRepository->findCompletesAndActivesWithScores($page, $limit, $sort, $order, $this->getUser());

        // Evite certaines erreurs dans le cas où l'on n'a pas de résultat
        if ($categories['pages'] === 0) {
            $categories['pages'] = 1;
        }

        $scores = [];
        foreach ($categories['data'] as $category) {
            foreach ($category->getQuestionnaires() as $questionnaire) {
                $scores[] = $questionnaire->getScores()[0];
            }
        }

        // On supprime les potentiels scores stockés en session
        $session = $request->getSession();
        $session->remove('answers');

        return $this->render('main/index.html.twig', compact('categories', 'scores'));
    }
}
