<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UsersFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(int $id, UsersRepository $usersRepository, EntityManagerInterface $manager, Request $request): Response
    {
        $user = $usersRepository->find($id);
        if (!$user) throw $this->createNotFoundException('Utilisateur introuvable');

        $form = $this->createForm(UsersFormType::class, $user);
        $form->get('role')->setData($user->getRoles()[0]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été modifié.');
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/users/edit.html.twig', compact('form'));
    }

    #[Route('/{id}', name: 'edit', methods: ['DELETE'])]
    public function remove(Users $user, EntityManagerInterface $manager): Response
    {
        $manager->remove($user);
        $manager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');
        return $this->redirectToRoute(('admin_users_index'));
    }
}
