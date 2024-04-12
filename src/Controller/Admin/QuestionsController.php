<?php

namespace App\Controller\Admin;

use App\Form\QuestionsFormType;
use App\Repository\QuestionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/questions', name: 'admin_questions_')]
class QuestionsController extends AbstractController
{
    #[Route('/{id}', name: 'edit')]
    public function index(int $id, QuestionsRepository $questionsRepository, Request $request): Response
    {
        $question = $questionsRepository->find($id);
        $form = $this->createForm(QuestionsFormType::class, $question);
        // $form->get('p1')->setData('test');
        // $form->get('answer')->setData('a1');

        $form->handleRequest($request);

        return $this->render('admin/questions/edit.html.twig', compact('form'));
    }
}
