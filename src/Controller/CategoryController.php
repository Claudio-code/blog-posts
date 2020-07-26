<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CatagoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/category", name="category")
 */
class CategoryController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render("category/index.html.twig", [
            "categories" => $categoryRepository->findAll()
        ]);
    }

    /**
     * @return Response
     * @Route("/create", name="_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(CatagoryType::class, new Category());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $category
                ->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
                ->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ;

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash("success", "criado nova categoria.");

            return  $this->redirectToRoute("category_index");

        }

        return $this->render("category/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/edit/{id}", name="_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CatagoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $category->setUpdatedAt(
                new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ;

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash("success", "alterada categoria");

            return  $this->redirectToRoute("category_index");
        }

        return $this->render("category/form.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/remove/{id}", name="_remove", methods={"GET", "POST"})
     */
    public function remove(Category $category): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($category);
        $manager->flush();
        $this->addFlash("errors", "deletado com sucesso.");

        return $this->redirectToRoute("category_index");
    }
}
