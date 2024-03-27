<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quizz/{slug}/{difficulty}', name: 'app_quizz_')]
class QuizzController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(string $slug, string $difficulty, CategoriesRepository $categoriesRepository, QuestionnairesRepository $questionnairesRepository): Response
    {
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);
        if (!$category) {
            return $this->redirectToRoute('app_main');
        }
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        if (!$questionnaire) {
            return $this->redirectToRoute('app_main');
        }

        return $this->render('quizz/index.html.twig', compact('category', 'questionnaire'));
    }

    #[Route('/{number}', name: 'start')]
    public function start(string $slug, string $difficulty, int $number, CategoriesRepository $categoriesRepository, QuestionnairesRepository $questionnairesRepository, QuestionsRepository $questionsRepository)
    {
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        $questions = $questionsRepository->findBy(['questionnaire' => $questionnaire->getId()]);
        $question = $questions[$number];

        return $this->render('quizz/start.html.twig', compact('category', 'questionnaire', 'question'));
    }
}
