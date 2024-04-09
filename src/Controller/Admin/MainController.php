<?php

namespace App\Controller\Admin;

use App\Repository\CategoriesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_main_')]
class MainController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository, UsersRepository $usersRepository): Response
    {
        $categories = $categoriesRepository->countCompletedAndActives();
        $users = $usersRepository->countVerified();

        return $this->render('admin/main/index.html.twig', compact('categories', 'users'));
    }
}
