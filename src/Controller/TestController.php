<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findOldPosts(2);
        dd($posts);        
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
        //return $this->json(['username'  => 'jane.doe']);
    }
    #[Route('/test/{id}', name: 'test_id', methods: ["GET"], requirements: ['id' => '\d+'])]
    public function test_id($id): Response
    {   //dd($id);
        return $this->render('test/test.html.twig', [
            'controller_name' => 'TestController IdController',
            'id' => $id,
        ]);
    }
}

