<?php

namespace App\Controller\Admin;

use App\Form\UsersFormType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/utilisateurs', name: 'admin_users_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();

        return $this->render('admin/users/index.html.twig', compact('users'));
    }

    #[Route('/{id}', name: 'edit')]
    public function edit(int $id, UsersRepository $usersRepository, Request $request): Response
    {
        $user = $usersRepository->find($id);
        if (!$user) throw $this->createNotFoundException('Utilisateur introuvable');

        $form = $this->createForm(UsersFormType::class, $user);
        $form->get('role')->setData($user->getRoles()[0]);

        return $this->render('admin/users/edit.html.twig', compact('form'));
    }
}
