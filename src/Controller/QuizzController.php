<?php

namespace App\Controller;

use App\Entity\Scores;
use App\Form\QuizzFormType;
use App\Repository\CategoriesRepository;
use App\Repository\PropositionsRepository;
use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use App\Repository\ScoresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $category = $categoriesRepository->findWithQuestionnaireAndScore($slug, $difficulty, $this->getUser());
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
        QuestionnairesRepository $questionnairesRepository,
        QuestionsRepository $questionsRepository,
        ScoresRepository $scoresRepository,
        Request $request,
        UserInterface $user,
        EntityManagerInterface $entityManager
    ): Response {
        $category = $categoriesRepository->findOneBy(['slug' => $slug]);
        if (!$category) throw $this->createNotFoundException('Catégorie inexistante');
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        if (!$questionnaire) throw $this->createNotFoundException('Difficulté incorrecte');
        $questions = $questionsRepository->findBy(['questionnaire' => $questionnaire->getId()]);
        $score = 0;

        // Récupère les informations de session
        $session = $request->getSession();
        $answers = $session->get('answers');

        // Si le tableau n'est pas créé, on renvoit à l'accueil du quizz
        if (!$answers) {
            return $this->redirectToRoute('app_quizz_index', compact('slug', 'difficulty'));
        }

        // Incrémente le score en fonction des bonnes réponses
        for ($i = 1; $i <= 10; $i++) {
            // S'assure en premier lieu que l'utilisateur n'a pas zappé une question
            if (!array_key_exists($i, $answers)) {
                return $this->redirectToRoute('app_quizz_question', [
                    'slug' => $slug,
                    'difficulty' => $difficulty,
                    'number' => $i
                ]);
            }

            if ($questions[$i - 1]->getAnswer() === $answers[$i]) {
                $score++;
            }
        }

        // Insère le score en base
        $lastScore = $scoresRepository->findOneBy(compact('questionnaire', 'user'));

        // Crée ou modifie le meilleur score
        if (!$lastScore) {
            $newScore = new Scores();
            $newScore->setQuestionnaire($questionnaire);
            $newScore->setUser($user);
            $newScore->setScore($score);

            $entityManager->persist($newScore);
            $entityManager->flush();
        } elseif ($lastScore->getScore() < $score) {
            $lastScore->setScore($score);

            $entityManager->persist($lastScore);
            $entityManager->flush();
        }

        return $this->render('quizz/end.html.twig', compact('category', 'questionnaire', 'score'));
    }

    #[Route('/{number}', name: 'question')]
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
        if (!$category) throw $this->createNotFoundException('Catégorie inexistante');
        $questionnaire = $questionnairesRepository->findOneBy(['category' => $category->getId(), 'difficulty' => $difficulty]);
        if (!$questionnaire) throw $this->createNotFoundException('Difficulté incorrecte');
        $questions = $questionsRepository->findBy(['questionnaire' => $questionnaire->getId()]);
        $question = $questions[$number - 1];
        $propositions = $propositionsRepository->findBy(['question' => $question->getId()]);

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
                if ($quizzForm->get((string)$i)->isClicked()) {
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
