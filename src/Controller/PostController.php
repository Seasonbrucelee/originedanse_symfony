<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('post/home.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    #[Route('/post/{id}', name: 'post_view')]
    public function post($id): Response
    {   
        return $this->render('post/view.html.twig', [
            'controller_name' => 'MaPagePost',
        ]);
    
    }
}
           
   /*#[Route('/post/{id}', name: 'post_id', methods: ["GET"], requirements: ['id' => '\d+'])]
    public function post_id($id): Response
    {
        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostControllerAvecId',
            'id' => $id,
        ]);
    }*/
