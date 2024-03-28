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
        if (!$category) return $this->redirectToRoute('app_main');

        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        if (!$questionnaire) return $this->redirectToRoute('app_main');

        $session = $request->getSession();
        $session->set('answers', [
            'category' => $category->getSlug(),
            'difficulty' => $questionnaire->getDifficulty()
        ]);

        return $this->render('quizz/index.html.twig', compact('category', 'questionnaire'));
    }

    #[Route('/fin', name: 'end')]
    public function end(string $slug, string $difficulty, CategoriesRepository $categoriesRepository, QuestionnairesRepository $questionnairesRepository, QuestionsRepository $questionsRepository, Request $request): Response
    {
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        $questions = $questionsRepository->findBy(['questionnaire' => $questionnaire->getId()]);

        $session = $request->getSession();
        $answers = $session->get('answers');

        $score = 0;
        for ($i = 1; $i <= 10; $i++) {
            if (!array_key_exists($i, $answers)) {
                return $this->redirectToRoute('app_quizz_start', [
                    'slug' => $slug,
                    'difficulty' => $difficulty,
                    'number' => $i
                ]);
            }

            if ($questions[$i - 1]->getAnswer() === $answers[$i]) {
                $score++;
            }
        }

        // $session->set('answers', []);

        return $this->render('quizz/end.html.twig', compact('category', 'questionnaire', 'score'));
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

        $session = $request->getSession();
        $answers = $session->get('answers');

        $quizzForm = $this->createForm(QuizzFormType::class);

        // Si on a déjà une réponse en session, on bloque toute nouvelle soumission du formulaire
        if (!array_key_exists($number, $answers)) {
            $quizzForm->handleRequest($request);
        }

        if ($quizzForm->isSubmitted() && $quizzForm->isValid()) {
            // Permet de capter quel bouton a été cliqué
            for ($i = 0; $i < 4; $i++) {
                // Si c'est cliqué, on récupère l'index et on ferme la boucle
                if ($quizzForm->get((string)$i)->isClicked()) {
                    $choice = $i;
                    $i = 4;
                }
            }

            $answers[$number] = $propositions[$choice]->getProposition();

            $session->set('answers', $answers);
        }

        $next = false;
        if (array_key_exists($number, $answers)) {
            $next = true;
        }

        return $this->render('quizz/start.html.twig', compact('category', 'questionnaire', 'question', 'propositions', 'quizzForm', 'answers', 'next', 'number'));
    }
}
