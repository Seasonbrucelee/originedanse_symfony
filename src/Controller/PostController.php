<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    #[Route('/post/{id}', name: 'post_id', methods: ["GET"], requirements: ['id' => '\d+'])]
    public function post_id($id): Response
    {
        return $this->render('post/post.html.twig', [
            'controller_name' => 'PostControllerAvecId',
            'id' => $id,
        ]);
    }


}
