<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route("/", name="_index", methods={"GET", "POST"})
     */
    public function index(UserRepository $repository): Response
    {
        return $this->render("user/list.html.twig", [
            "users" => $repository->findAll()
        ]);
    }

    /**
     * @return Response
     * @Route("/remove/{id}", name="_remove", methods={"GET", "POST"})
     */
    public function remove(User $user): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash("errors", "deletado com sucesso.");

        return $this->redirectToRoute("user_index");
    }

    /**
     * @return Response
     * @Route("/edit/{id}", name="_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setUpdatedAt(
                new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"))
            );

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success", "editado novo usuario");

            return  $this->redirectToRoute("user_index");
        }

        return $this->render("user/index.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @return Response
     * @Route("/create", name="_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user
                ->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
                ->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ;

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success", "criado novo usuario");

            return  $this->redirectToRoute("user_index");
        }

        return $this->render("user/index.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
