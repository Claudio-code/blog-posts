<?php

namespace App\Controller;

use App\Entity\Coment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment", name="comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="_index")
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * @Route("/create/{id}", name="_save", methods={"POST"})
     * @param Post $post
     * @param Request $request
     * @return Response
     */
    public function create(Post $post, Request $request): Response
    {
        $form = $this->createForm(CommentType::class, new Coment());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($comment);
            $manager->flush();
        }

        return $this->render("single.html.twig", [
            "post" => $post,
            "form" => $form->createView()
        ]);
    }
}
