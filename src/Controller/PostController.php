<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/post", name="post")
 */
class PostController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render("post/index.html.twig", [
            "posts" => $postRepository->findAll()
        ]);
    }

    /**
     * @return Response
     * @Route("/remove/{id}", name="_remove", methods={"GET", "POST"})
     */
    public function remove(Post $post): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($post);
        $manager->flush();
        $this->addFlash("errors", "deletado com sucesso.");

        return $this->redirectToRoute("user_index");
    }

    /**
     * @return Response
     * @Route("/edit/{id}", name="_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setUpdatedAt(
                new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ;
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            $this->addFlash("success", "alterado novo post");

            return  $this->redirectToRoute("post_index");
        }

        return $this->render("post/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/create", name="_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(PostType::class, new Post());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post
                ->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
                ->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ;
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
            $this->addFlash("success", "criado novo post");

            return  $this->redirectToRoute("post_index");
        }

        return $this->render("post/create.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
