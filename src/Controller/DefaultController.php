<?php

namespace App\Controller;

use \Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class DefaultController
 * @package App\Controller
 *
 * @Route("/", name="default")
 */
class DefaultController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="default_index", methods={"GET"})
     */
    public function index(): Response
    {
        $posts = [
            [
                "id" => 1,
                "title" => "post 1",
                "create_at" => "2020-02-10 13:43:04"
            ],
            [
                "id" => 2,
                "title" => "post 2",
                "create_at" => "2004-04-04 15:23:04"
            ],
            [
                "id" => 3,
                "title" => "post 3",
                "create_at" => "2024-04-10 11:21:14"
            ]
        ];

        return $this->render("index.html.twig", [
            "title" => "Home page",
            "posts" => $posts
        ]);
    }
}