<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/post", name="post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }

    /**
     * @Route("/create", name="post_create", methods={"POST"})
     */
    public function create(): Response
    {
        return $this->render('post/create.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
