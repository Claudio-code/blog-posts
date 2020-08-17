<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/user", name="user")
 */
class UserController extends AbstractController
{
    /**
     * @param UserRepository $repository
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
     * @param User $user
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
     * @param Request $request
     * @param User $user
     * @return Response
     * @throws \Exception
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerService $mailerService
     * @return Response
     * @throws \Exception
     * @Route("/create", name="_create", methods={"GET", "POST"})
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerService $mailerService): Response
    {
        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // dados para enviar o email
            $data = [
                'subject' => 'Blog post usario criado com sucesso',
                'email' => $user->getEmail(),
            ];
            $view = $this->renderView('email/newUser.html.twig', [
                'name' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles("ROLE_ADMIN");

            $user
                ->setCreatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
                ->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ;

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $mailerService->execute($view, $data);
            $this->addFlash("success", "criado novo usuario");
            return $this->redirectToRoute("user_index");
        }

        return $this->render("user/index.html.twig", [
            "form" => $form->createView()
        ]);
    }
}
