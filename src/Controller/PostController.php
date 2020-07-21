<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/post", name="post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render("post/index.html.twig");
    }

    /**
     * @Route("/create", name="_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $data = $request->request->all();

        if (empty($data)) {
            return $this->render("post/create.html.twig");
        }

        $post = new Post();
        $post
            ->setTitle($data["title"])
            ->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ->setDescription($data["description"])
            ->setSlug($data["slug"])
            ->setContent($data["content"])
        ;

        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($post);
        $doctrine->flush();

        return $this->render("post/index.html.twig");
    }
}
