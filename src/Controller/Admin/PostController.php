<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;

use App\Repository\PostRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/post', name: 'admin_post_')]
class PostController extends AbstractController
{   
    /* Cette Route appelle une vue */
    #[Route('/', name: 'index')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        
        return $this->render('admin/post/index.html.twig', [
            /* Tableau des données qui est envoyé à la vue */
            'posts' => $posts,
        ]);
    }

    #[Route('/add', name: 'add')]
    /** (Request $request) = Objet Request et injection de dépendance */
    
    public function addPost(Request $request, ManagerRegistry $doctrine): Response
    {
        //dd($request);
        // Instance de Category 
        $post = new Post();
        //dd($category);
        //On demande de fabriquer un formulaire. en mémoire de préfabriquer un contenu HTML sur la base de ce que l'on a mit dans le fichier formulaire PHP
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $post->setUser($this->getUser());
            $post->setActive(true);
            //$em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->persist($post);
            $em->flush();
        return $this->redirectToRoute('admin_post_index');
        }
        //dd($form->createView());
        //dd($form);
        //On appelle une vue et on lui passe le form transformé en html
        /*return $this->render('admin/index.html.twig', [
            'controller_name' => 'Add Category',*/
        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajout d\'un article',
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    /** (Request $request) = Objet Request et injection de dépendance */
    public function updatePost(Post $post, Request $request, ManagerRegistry $doctrine): Response
    {
        //Comme l'instance est déjà rempli on enlève la variable ci-dessous 
        //$category = new Category();
        
        //dd($category);
        //On demande de fabriquer un formulaire. en mémoire de préfabriquer un contenu HTML sur la base de ce que l'on a mit dans le fichier formulaire PHP
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $em = $doctrine->getManager();
            $em->flush();
        return $this->redirectToRoute('admin_post_index');
        }
        //dd($form->createView());
        //dd($form);
        //On appelle une vue et on lui passe le form transformé en html
        /*return $this->render('admin/index.html.twig', [
            'controller_name' => 'Add Category',*/
        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modification d\'un article',
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Post $post, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($post);
        $em->flush();
        $this->addFlash('success', 'Article supprimé !');
        return $this->redirectToRoute('admin_post_index');
    }
}

