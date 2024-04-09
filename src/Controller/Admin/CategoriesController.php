<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Questionnaires;
use App\Form\CategoriesFormType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/categories', name: 'admin_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findAllWithUserAndNumberOfQuestions();

        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }

    #[Route('/ajouter', name: 'add')]
    public function add(SluggerInterface $slugger, UserInterface $user, EntityManagerInterface $manager, Request $request): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setSlug($slugger->slug($category->getTitle())->lower());
            $category->setUser($user);

            // On récupère l'image et l'extension
            $image = $form->get('image')->getData();
            $extension = $image->guessExtension();

            // On définie son nom à partir du slug de la catégorie
            $imageName = $category->getSlug() . '.' . $extension;

            // On la crée dans le dossier public/img/
            $image->move($this->getParameter('images_directory'), $imageName);

            // On indique à l'objet le nom de l'image
            $category->setImage($imageName);

            $difficulties = ['facile', 'moyen', 'difficile'];
            foreach ($difficulties as $difficulty) {
                $questionnaire = new Questionnaires();
                $questionnaire->setDifficulty($difficulty);
                $questionnaire->setCategory($category);

                $manager->persist($questionnaire);
            }

            $manager->persist($category);
            $manager->flush();

            // return $this->redirectToRoute('admin_categories_index');
        }

        return $this->render('admin/categories/add.html.twig', compact('form'));
    }
}
