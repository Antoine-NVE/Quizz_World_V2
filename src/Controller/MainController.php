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
        $categories = $categoriesRepository->findCompletesAndActives();

        // On supprime les potentiels scores stockés en session
        $session = $request->getSession();
        $session->remove('answers');

        return $this->render('main/index.html.twig', compact('categories'));
    }
}
