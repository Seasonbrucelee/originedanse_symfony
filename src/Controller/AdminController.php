<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    /**HOME PAGE DU FUTRE BACK-OFFICE**/
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    #[Route('/category/add', name: 'category_add')]
    /** (Request $request) = Objet Request et injection de dépendance */
    public function addCategory(Request $request): Response
    {
        //dd($request);

        // Instance de Category 
        $category = new Category();
        
        //dd($category);
        //On demande de fabriquer un formulaire. en mémoire de préfabriquer un contenu HTML sur la base de ce que l'on a mit dans le fichier formulaire PHP
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
        return $this->redirectToRoute('admin_home');
        }
        //dd($form->createView());
        //dd($form);
        //On appelle une vue et on lui passe le form transformé en html
        /*return $this->render('admin/index.html.twig', [
            'controller_name' => 'Add Category',*/
        return $this->render('admin/category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

