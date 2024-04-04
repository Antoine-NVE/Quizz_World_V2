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
        $scores = [];
        $categories = $categoriesRepository->findCompletesAndActivesWithScores($this->getUser());
        foreach ($categories as $category) {
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
