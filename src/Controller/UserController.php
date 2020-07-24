<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
     * @Route("/", name="_index", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
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

        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
