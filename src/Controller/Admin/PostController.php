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
            'posts' => $posts,
        ]);
    }
    #[Route('add', name:'add')]
    public function addPost(Request $request, ManagerRegistry $doctrine): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
        $post->setUser($this->getUser());
        $post->setActive(false);
        //$em = $this->getDoctrine()->getManager();
        $em = $doctrine->getManager();
        $em->persist($post);
        $em->flush();
        return $this->redirectToRoute('home');
    }
        return $this->render('admin/post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   /**#[Route('/post/{slug}', name: 'post_view')] //was app_post
    public function post(Post $post): Response
    {   
        //dd($post);
        return $this->render('post/view.html.twig', [
            'post' => $post               
        ]);
    }***/
    #[Route('/post/{slug}', name: 'post_view')]
    public function post(Post $post): Response
    {   
        //dd($post);

        return $this->render('admin/post/view.html.twig', [
            'post' => $post

          /*return $this->render('post/view.html.twig', [
            'post' => [
                'title' => 'Film RIZE',
                'content' => '
                Rize révèle un phénomène urbain qui est en train d\'exploser à Los Angeles et de se propager sur la Côte Est. Parce qu\'il est au contact de celui-ci depuis longtemps, le photographe David Lachapelle a réussi à saisir la naissance d\'une forme révolutionnaire d\'expression artistique issue du mal de vivre des exclus du rêve américain : le krumping.

                Cette danse agressive et visuellement incroyable, alternative à la danse hip hop habituelle, prend ses racines dans les danses tribales africaines et se caractérise par des pas et des mouvements d\'une vitesse et d\'une difficulté inégalées.

                Rize suit cette fascinante évolution à travers l\'histoire de Tommy le Clown, un éducateur de South Central à Los Angeles, qui a inventé cette danse en réponse aux émeutes raciales consécutives à l\'affaire Rodney King.'
            ],*/
        ]);
       }
}
   /***#[Route('/post/{id}', name: 'post_id', methods: ["GET"], requirements: ['id' => '\d+'])]
    public function post_id($id): Response
    {
        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostControllerAvecId',
            'id' => $id,
        ]);
    }***/
