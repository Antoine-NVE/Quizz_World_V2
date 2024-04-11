<?php

namespace App\Controller\Admin;

use App\Repository\QuestionnairesRepository;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/questionnaires', name: 'admin_questionnaires_')]
class QuestionnairesController extends AbstractController
{
    #[Route('/{id}', name: 'index')]
    public function index(int $id, QuestionnairesRepository $questionnairesRepository, QuestionsRepository $questionsRepository): Response
    {
        $questionnaire = $questionnairesRepository->find($id);
        $questions = $questionsRepository->findBy(['questionnaire' => $questionnaire]);

        return $this->render('admin/questionnaires/index.html.twig', compact('questionnaire', 'questions'));
    }
}
