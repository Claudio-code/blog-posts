<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        return $this->render("index.html.twig");
    }
}