<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Ici on définit la partie commune de toutes les catégories
#[Route('/admin/category', name: 'admin_category_')]
class CategoryController extends AbstractController
{   
    /* Ici on définit la Route qui va déclencher la fonction */
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        // Ci-dessous on envoi à la vue les données
        return $this->render('admin/category/index.html.twig', [
            /* Tableau des données qui est envoyé à la vue */
            'categories' => $categories,
        ]);
    }

    #[Route('/add', name: 'add')]
    /** (Request $request) = Objet Request et injection de dépendance */
    public function addCategory(Request $request, ManagerRegistry $doctrine): Response
    {
        //dd($request);
        // Instance de Category 
        $category = new Category();
        
        //dd($category);
        //On demande de fabriquer un formulaire en mémoire de préfabriquer un contenu HTML sur la base de ce que l'on a mit dans le fichier formulaire PHP
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();
        return $this->redirectToRoute('admin_category_index');
        }
        //dd($form->createView());
        //dd($form);
        //On appelle une vue et on lui passe le form transformé en html
        /*return $this->render('admin/index.html.twig', [
            'controller_name' => 'Add Category',*/
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajout d\'une catégorie',
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    /** (Request $request) = Objet Request et injection de dépendance */
    public function updateCategory(Category $category, Request $request, ManagerRegistry $doctrine): Response
    {
        //Comme l'instance est déjà rempli on enlève la variable ci-dessous 
        //$category = new Category();
        
        //dd($category);
        //On demande de fabriquer un formulaire. en mémoire de préfabriquer un contenu HTML sur la base de ce que l'on a mit dans le fichier formulaire PHP
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->flush();
        return $this->redirectToRoute('admin_category_index');
        }
        //dd($form->createView());
        //dd($form);
        //On appelle une vue et on lui passe le form transformé en html
        /*return $this->render('admin/index.html.twig', [
            'controller_name' => 'Add Category',*/
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modification d\'une catégorie',
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Category $category, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash('success', 'Catégorie supprimée !');
        return $this->redirectToRoute('admin_category_index');
    }
}

