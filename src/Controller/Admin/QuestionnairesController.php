<?php

namespace App\Controller\Admin;

use App\Entity\Propositions;
use App\Entity\Questions;
use App\Form\QuestionsFormType;
use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/questionnaires', name: 'admin_questionnaires_')]
class QuestionnairesController extends AbstractController
{
    #[Route('/{id}/ajouter', name: 'add')]
    public function add(int $id, QuestionnairesRepository $questionnairesRepository, QuestionsRepository $questionsRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $questionnaire = $questionnairesRepository->findWithQuestions($id);
        $questions = $questionnaire->getQuestions();

        // Empêche d'avoir plus de 10 questions
        if (count($questions) >= 10) {
            throw $this->createAccessDeniedException('Ce questionnaire est déjà composé de 10 questions.');
        }

        $question = new Questions();
        $question->setQuestionnaire($questionnaire);
        $form = $this->createForm(QuestionsFormType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propositions = [
                new Propositions(),
                new Propositions(),
                new Propositions(),
                new Propositions()
            ];

            for ($i = 0; $i < 4; $i++) {
                // On récupère la proposition de l'input
                $proposition = $form->get('p' . $i + 1)->getData();

                // On set
                $propositions[$i]->setProposition($proposition);
                $propositions[$i]->setQuestion($question);

                // Si c'est la bonne réponse, on modifie l'objet
                if ($form->get('answer')->getData() === 'a' . $i + 1) {
                    $question->setAnswer($proposition);

                    $manager->persist($question);
                }

                $manager->persist($propositions[$i]);
            }

            $manager->flush();

            $this->addFlash('success', 'La question a bien été créée.');
            return $this->redirectToRoute('admin_questionnaires_index', ['id' => $questionnaire->getId()]);
        }

        return $this->render('admin/questionnaires/add.html.twig', compact('form', 'questionnaire'));
    }

    #[Route('/{id}', name: 'index')]
    public function index(int $id, QuestionnairesRepository $questionnairesRepository, QuestionsRepository $questionsRepository): Response
    {
        $questionnaire = $questionnairesRepository->findWithQuestions($id);
        if (!$questionnaire) throw $this->createNotFoundException('Aucun questionnaire trouvé.');
        $questions = $questionnaire->getQuestions();

        return $this->render('admin/questionnaires/index.html.twig', compact('questionnaire', 'questions'));
    }
}
