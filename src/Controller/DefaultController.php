<?php

namespace App\Controller;

use App\Entity\Coment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use \Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @param PostRepository $postRepository
     * @return Response
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, PostRepository $postRepository): Response
    {
        $page = $request->query->getInt('page', 1);
        $allPosts = $postRepository->findAll();
        $posts = $paginator->paginate($allPosts, $page, 2);

        return $this->render("index.html.twig", [
            "title" => "Home page",
            "posts" => $posts
        ]);
    }

    /**
     * @param Post $post
     * @return Response
     * @Route("/{id}", name="single_post", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function single(Post $post): Response
    {
        $form = $this->createForm(CommentType::class, new Coment());

        return $this->render("single.html.twig", [
            "post" => $post,
            "form" => $form->createView()
        ]);
    }
}