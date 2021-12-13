<?php

namespace App\Controller;

use App\Entity\UserClient;
use App\Form\RegistrationType;
use App\Notification\EmailNotification;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EmailNotification $notification
     * @return mixed
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder, EmailNotification $notification)
    {
        $user_client = new UserClient();

        $form = $this->createForm(RegistrationType::class, $user_client);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user_client, $user_client->getPassword());
            $user_client->setPassword($hash);
            $this->getDoctrine()->getManager()->persist($user_client);
            $this->getDoctrine()->getManager()->flush();

            $notification->sendConfirmation($user_client);

            return $this->redirectToRoute("security_login_client");
        }

        return $this->render("security/registration.html.twig", [
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login_client")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $lastUsername=$authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render("security/connect.html.twig", [
            'last_username'  => $lastUsername,
            'error'          => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function logout() {
        $this->addFlash('success', 'Vous vous êtes bien déconnecté');
        return $this->redirectToRoute("home");
    }
}
