<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use \Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class DefaultController
 * @package App\Controller
 *
 * @Route("/", name="home_")
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render("index.html.twig", [
            "title" => "Home page",
            "posts" => $posts
        ]);
    }

    /**
     * @return Response
     * @Route("/{id}", name="single_post", methods={"GET"})
     */
    public function single(Post $post): Response
    {
        return $this->render("single.html.twig", [
            "post" => $post
        ]);
    }
}