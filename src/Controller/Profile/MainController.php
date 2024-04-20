<?php

namespace App\Controller\Profile;

use App\Repository\CategoriesRepository;
use App\Repository\ScoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/profil', name: 'profile_main')]
    public function index(ScoresRepository $scoresRepository, CategoriesRepository $categoriesRepository): Response
    {
        $user = $this->getUser();
        $scores = $scoresRepository->countByUser($user);
        $categories = $categoriesRepository->countCompletedAndActivesByUser($user);

        return $this->render('profile/main/index.html.twig', compact('scores', 'categories', 'user'));
    }
}
