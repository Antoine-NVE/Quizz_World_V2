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
        $categories = $categoriesRepository->findAllWithQuestionnairesAndQuestionsAndUser();

        return $this->render('admin/categories/index.html.twig', compact('categories'));
    }

    #[Route('/ajouter', name: 'add')]
    public function add(SluggerInterface $slugger, UserInterface $user, EntityManagerInterface $manager, Request $request): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesFormType::class, $category);

        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $category->setSlug($slugger->slug($category->getTitle())->lower());
                $category->setUser($user);

                // On récupère l'image
                $image = $form->get('image')->getData();

                // On définit son nom
                $imageName = uniqid() . '.webp';

                // On indique à l'objet le nom de l'image
                $category->setImage($imageName);

                // On la crée dans le dossier public/img/
                $image->move($this->getParameter('images_directory'), $category->getImage());

                $difficulties = ['facile', 'moyen', 'difficile'];
                foreach ($difficulties as $difficulty) {
                    $questionnaire = new Questionnaires();
                    $questionnaire->setDifficulty($difficulty);
                    $questionnaire->setCategory($category);

                    $manager->persist($questionnaire);
                }
                $manager->persist($category);

                $manager->flush();
                $this->addFlash('success', 'La catégorie a bien été créée');
                return $this->redirectToRoute('admin_categories_index');
            }
        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
        }

        return $this->render('admin/categories/add.html.twig', compact('form'));
    }

    #[Route('/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        int $id,
        CategoriesRepository $categoriesRepository,
        SluggerInterface $slugger,
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        $category = $categoriesRepository->findOneOrNullWithQuestionnairesAndQuestions($id);
        if (!$category) throw $this->createNotFoundException('Catégorie non trouvée.');
        $questionnaires = $category->getQuestionnaires();

        // On crée le formulaire en spécifiant que l'input image n'est pas obligatoire
        $form = $this->createForm(CategoriesFormType::class, $category, ['image_required' => false]);

        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $category->setSlug($slugger->slug($category->getTitle())->lower());

                // On récupère l'image du formulaire
                $image = $form->get('image')->getData();

                // Si elle n'est pas null, on modifie celle qui est stockée
                if ($image) {
                    // On récupère le nom de la base
                    $imageName = $category->getImage();

                    // On la modifie dans le dossier public/img/
                    $image->move($this->getParameter('images_directory'), $imageName);
                }

                $manager->persist($category);

                $manager->flush();
                $this->addFlash('success', 'La catégorie a bien été modifiée');
                return $this->redirectToRoute('admin_categories_index');
            }
        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
        }

        return $this->render('admin/categories/edit.html.twig', compact('form', 'category', 'questionnaires'));
    }

    #[Route('/{id}', name: 'remove', methods: ['DELETE'])]
    public function remove(Categories $category, EntityManagerInterface $manager): Response
    {
        // On récupère le nom de l'image, et on concatène avec le répertoire complet
        $image = $category->getImage();
        $imageName = $this->getParameter('images_directory') . '/' . $image;

        try {
            $manager->remove($category);

            $manager->flush();

            // Si tout s'est bien passé, on peut supprimer l'image physique
            unlink($imageName);

            $this->addFlash('success', 'La catégorie a bien été supprimée');
        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
        }

        return $this->redirectToRoute('admin_categories_index');
    }
}
