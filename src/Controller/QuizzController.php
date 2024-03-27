<?php

namespace App\Controller;

use App\Form\QuizzFormType;
use App\Repository\CategoriesRepository;
use App\Repository\PropositionsRepository;
use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quizz/{slug}/{difficulty}', name: 'app_quizz_')]
class QuizzController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(string $slug, string $difficulty, CategoriesRepository $categoriesRepository, QuestionnairesRepository $questionnairesRepository, Request $request): Response
    {
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);
        if (!$category) {
            return $this->redirectToRoute('app_main');
        }
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        if (!$questionnaire) {
            return $this->redirectToRoute('app_main');
        }

        $session = $request->getSession();

        $session->set('answers', [
            'category' => $category->getSlug(),
            'difficulty' => $questionnaire->getDifficulty()
        ]);

        return $this->render('quizz/index.html.twig', compact('category', 'questionnaire'));
    }

    #[Route('/end', name: 'end')]
    public function end(Request $request): Response
    {
        $session = $request->getSession();

        $session->set('answers', []);


        return $this->render('quizz/end.html.twig');
    }

    #[Route('/{number}', name: 'start')]
    public function start(
        string $slug,
        string $difficulty,
        int $number,
        CategoriesRepository $categoriesRepository,
        QuestionnairesRepository $questionnairesRepository,
        QuestionsRepository $questionsRepository,
        PropositionsRepository $propositionsRepository,
        Request $request
    ): Response {
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        $questions = $questionsRepository->findBy(['questionnaire' => $questionnaire->getId()]);
        $question = $questions[$number - 1];
        $propositions = $propositionsRepository->findBy(['question' => $question->getId()]);

        $quizzForm = $this->createForm(QuizzFormType::class);

        $quizzForm->handleRequest($request);

        $session = $request->getSession();

        $answers = $session->get('answers');



        if ($quizzForm->isSubmitted() && $quizzForm->isValid()) {
            if ($quizzForm->get('0')->isClicked()) {
                $choice = 0;
            } else if ($quizzForm->get('1')->isClicked()) {
                $choice = 1;
            } else if ($quizzForm->get('2')->isClicked()) {
                $choice = 2;
            } else if ($quizzForm->get('3')->isClicked()) {
                $choice = 3;
            };

            if ($question->getAnswer() === $propositions[$choice]->getProposition()) {
                $is_good = true;
            } else {
                $is_good = false;
            }

            $answers[$number] = [
                $propositions[$choice]->getProposition(),
                $is_good
            ];

            $session->set('answers', $answers);
        }

        $next = false;
        if (array_key_exists($number, $answers)) {
            $next = true;
        }

        return $this->render('quizz/start.html.twig', compact('category', 'questionnaire', 'question', 'propositions', 'quizzForm', 'answers', 'next', 'number'));
    }
}
