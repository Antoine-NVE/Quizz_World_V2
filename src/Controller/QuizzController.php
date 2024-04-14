<?php

namespace App\Controller;

use App\Entity\Scores;
use App\Form\QuizzFormType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quizz/{slug}/{difficulty}', name: 'app_quizz_')]
class QuizzController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        string $slug,
        string $difficulty,
        CategoriesRepository $categoriesRepository,
        Request $request
    ): Response {
        $user = $this->getUser();
        $category = $categoriesRepository->findOneOrNullWithQuestionnaireQuestionsPropositionsAndScore($slug, $difficulty, $user);
        if (!$category) throw $this->createNotFoundException('Catégorie ou difficulté incorrecte');
        $questionnaire = $category->getQuestionnaires()[0];
        $score = $questionnaire->getScores()[0];

        // Remplit la session avec le slug et la difficulté
        $session = $request->getSession();
        $session->set('answers', [
            'slug' => $category->getSlug(),
            'difficulty' => $questionnaire->getDifficulty()
        ]);

        return $this->render('quizz/index.html.twig', compact('category', 'questionnaire', 'score'));
    }

    #[Route('/fin', name: 'end')]
    public function end(
        string $slug,
        string $difficulty,
        CategoriesRepository $categoriesRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $category = $categoriesRepository->findOneOrNullWithQuestionnaireQuestionsPropositionsAndScore($slug, $difficulty, $user);
        if (!$category) throw $this->createNotFoundException('Catégorie ou difficulté incorrecte');
        $questionnaire = $category->getQuestionnaires()[0];
        $questions = $questionnaire->getQuestions();
        $bestScore = $questionnaire->getScores()[0];

        // Récupère les informations de session
        $session = $request->getSession();
        $answers = $session->get('answers');

        // Si le tableau n'est pas créé, on renvoit à l'accueil du quizz
        if (!$answers) {
            return $this->redirectToRoute('app_quizz_index', compact('slug', 'difficulty'));
        }

        // Incrémente le score en fonction des bonnes réponses
        $score = 0;
        for ($i = 1; $i <= 10; $i++) {
            // S'assure en premier lieu que l'utilisateur n'a pas zappé une question
            if (!array_key_exists($i, $answers)) {
                return $this->redirectToRoute('app_quizz_question', [
                    'slug' => $slug,
                    'difficulty' => $difficulty,
                    'number' => $i
                ]);
            }

            // Incrémente
            if ($questions[$i - 1]->getAnswer() === $answers[$i]) {
                $score++;
            }
        }

        // Crée ou modifie le meilleur score
        if (!$bestScore) {
            $bestScore = new Scores();
            $bestScore->setQuestionnaire($questionnaire);
            $bestScore->setUser($user);
            $bestScore->setScore($score);

            $entityManager->persist($bestScore);
            $entityManager->flush();
        } elseif ($bestScore->getScore() < $score) {
            $bestScore->setScore($score);

            $entityManager->persist($bestScore);
            $entityManager->flush();
        }
        $score = $bestScore;

        return $this->render('quizz/end.html.twig', compact('category', 'questionnaire', 'score'));
    }

    #[Route('/{number}', name: 'question')]
    public function start(
        string $slug,
        string $difficulty,
        int $number,
        CategoriesRepository $categoriesRepository,
        Request $request
    ): Response {
        $user = $this->getUser();
        $category = $categoriesRepository->findOneOrNullWithQuestionnaireQuestionsPropositionsAndScore($slug, $difficulty, $user);
        if (!$category) throw $this->createNotFoundException('Catégorie ou difficulté incorrecte');
        $questionnaire = $category->getQuestionnaires()[0];
        $question = $questionnaire->getQuestions()[$number - 1];
        $propositions = $question->getPropositions();

        $session = $request->getSession();
        $answers = $session->get('answers');

        // Si le tableau n'est pas créé, on renvoit à l'accueil du quizz
        if (!$answers) {
            return $this->redirectToRoute('app_quizz_index', compact('slug', 'difficulty'));
        }

        // On vérifie que l'utilisateur n'a pas changé de quizz en cours de route
        if (($answers['slug'] !== $slug) || ($answers['difficulty'] !== $difficulty)) {
            return $this->redirectToRoute('app_quizz_index', compact('slug', 'difficulty'));
        }

        $quizzForm = $this->createForm(QuizzFormType::class);

        // Si on a déjà une réponse en session, on bloque toute nouvelle soumission du formulaire
        if (!array_key_exists($number, $answers)) {
            $quizzForm->handleRequest($request);
        }

        if ($quizzForm->isSubmitted() && $quizzForm->isValid()) {
            // Permet de capter quel bouton a été cliqué
            for ($i = 0; $i < 4; $i++) {
                // Si c'est cliqué, on récupère l'index et on ferme la boucle
                /** @var ClickableInterface $button  */
                $button = $quizzForm->get((string)$i);
                if ($button->isClicked()) {
                    $choice = $i;
                    $i = 4;
                }
            }

            // On remplit la session avec la réponse de l'utilisateur
            $answers[$number] = $propositions[$choice]->getProposition();
            $session->set('answers', $answers);
        }

        // Si la réponse est stockée en session, on affiche le bouton 'Suivant'
        if (array_key_exists($number, $answers)) {
            $next = true;
        } else {
            $next = false;
        }

        return $this->render('quizz/question.html.twig', compact('category', 'questionnaire', 'question', 'propositions', 'quizzForm', 'answers', 'next', 'number'));
    }
}
