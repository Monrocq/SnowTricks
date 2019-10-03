<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Notification\ValidationNotification;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        ObjectManager $em,
        UserPasswordEncoderInterface $encoder,
        CsrfTokenManagerInterface $tokenManager
    )
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->tokenManager = $tokenManager;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/register", name="register")
     */
    public function register(AuthenticationUtils $authenticationUtils, Request $request, ValidationNotification $notification)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new User();
        $userType = $this->createForm(UserType::class, $user);
        $userType->handleRequest($request);

        if ($userType->isSubmitted() && $userType->isValid()) {
            $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
            $user->setSignUpAt(new \DateTime('now'));
            $user->setValidated(0);
            $this->em->persist($user);
            $this->em->flush();
            
            //$token = $request->request->get('token');
            $token = $this->tokenManager->getToken('validation'.$user->getId())->getValue();
            $notification->notify($user, $token);
            
            $this->addFlash('success', 'Votre compte a bien été enregistré, merci de cliquer sur le lien de validation qui vous a été envoyé par mail pour avoir vous connecter.');
            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $userType->createView()
        ]);
    }

    /**
     * @param User $user
     * @Route("/validation/{id}", name="validation")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validation(User $user, Request $request)
    {
        $submittedToken = $request->query->get('token');
        dump($submittedToken);
        if ($this->isCsrfTokenValid('validation'.$user->getId(), $submittedToken)) {
            $user->setValidated(1);
            $this->em->flush();
            return $this->redirectToRoute('login');
        }
        return new Response('Erreur dans le token');
    }
    
}
