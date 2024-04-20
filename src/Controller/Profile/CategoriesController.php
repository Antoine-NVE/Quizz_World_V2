<?php

namespace App\Controller\Profile;

use App\Entity\Categories;
use App\Entity\Questionnaires;
use App\Form\CategoriesFormType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/profil/categories', name: 'profile_categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $categories = $categoriesRepository->findAllWithQuestionnairesAndQuestionsByUser($this->getUser());

        return $this->render('profile/categories/index.html.twig', compact('categories'));
    }

    #[Route('/ajouter', name: 'add')]
    public function add(SluggerInterface $slugger, EntityManagerInterface $manager, Request $request): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesFormType::class, $category);

        try {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $category->setSlug($slugger->slug($category->getTitle())->lower());
                $category->setUser($this->getUser());

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
                return $this->redirectToRoute('profile_categories_index');
            }
        } catch (\Throwable $th) {
            $this->addFlash('danger', 'Une erreur est survenue.');
        }

        return $this->render('profile/categories/add.html.twig', compact('form'));
    }

    #[Route('/{slug}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        string $slug,
        CategoriesRepository $categoriesRepository,
        SluggerInterface $slugger,
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        $category = $categoriesRepository->findOneOrNullWithQuestionnairesAndQuestionsBySlugAndUser($slug, $this->getUser());
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
                return $this->redirectToRoute('profile_categories_index');
            }
        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
        }

        return $this->render('profile/categories/edit.html.twig', compact('form', 'category', 'questionnaires'));
    }

    #[Route('/{slug}', name: 'remove', methods: ['DELETE'])]
    public function remove(string $slug, CategoriesRepository $categoriesRepository, EntityManagerInterface $manager): Response
    {
        $category = $categoriesRepository->findOneBy(['slug' => $slug, 'user' => $this->getUser()]);
        if (!$category) throw $this->createNotFoundException('Catégorie non trouvée.');

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

        return $this->redirectToRoute('profile_categories_index');
    }
}
