<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\User;
use App\Services\MainPicture;
use App\Form\MainPictureType;
use App\Form\UserType;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Notification\ValidationNotification;
use App\Notification\ResetNotification;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class SecurityController extends AbstractController
{
    public function __construct(
        ObjectManager $em,
        UserPasswordEncoderInterface $encoder,
        CsrfTokenManagerInterface $tokenManager,
        UserRepository $repository,
        PhotoRepository $photoRepo
    )
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->tokenManager = $tokenManager;
        $this->repository = $repository;
        $this->photoRepo = $photoRepo;
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
     * @Route("/register", name="register")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function register(AuthenticationUtils $authenticationUtils, Request $request, ValidationNotification $notification)
    {


        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new User();
        $userType = $this->createForm(UserType::class, $user);
        $userType->handleRequest($request);

        //return Response::create('test', 200, []);

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
        $photo = new MainPicture();
        $photoType = $this->createForm(MainPictureType::class, $photo);
        $photoType->handleRequest($request);
        
        $submittedToken = $request->query->get('token');
        
        if ($photoType->isSubmitted() && $photoType->isValid()) {
            $avatar = $this->photoRepo->findOneBy(array('user' => $user));
            
            if ($avatar == false) {
                $picture = new Photo();
                $picture->setUser($user);
                $persist = true;
            } else {
                $picture = $avatar;
                $persist = false;
            }
            
            $file = $photo->getName(); //ça recup le fichier
            $extension = $file->guessExtension();
            $fileName = $user->getUsername().'.'.$extension;
            $file->move($this->getParameter('avatar_directory'), $fileName);
            
            $picture->setUrl('img/avatar/'.$fileName);
            if ($persist == true) {
                $this->em->persist($picture);
            }
            $this->em->flush();
            return $this->redirectToRoute('login');
            
        } else {
            if ($this->isCsrfTokenValid('validation' . $user->getId(), $submittedToken)) {
                $user->setValidated(1);
                $this->em->flush();
                return $this->render('security/validation.html.twig', [
                    'form' => $photoType->createView()
                ]);
            }
        }
        return new Response('Erreur dans le token');
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request, ResetNotification $notification)
    {
        $username = $request->request->get('username');
        $token = $this->tokenManager->getToken('reset'.$username)->getValue();
        $user = $this->repository->findOneBy(array('username' => $username));

        if ($user == false) {
            $this->addFlash('echec', 'Ce nom d\'utilisateur n\'existe pas.');
            return $this->redirectToRoute('login');
        }
        
        $notification->send($user, $token);

        $user->setResetQueryAt(new \DateTime('now'));
        $this->em->flush();

        $this->addFlash('success', 'Mail de réinitialisation bien envoyé, checkez vos indésirables');
        return $this->redirectToRoute('login');
    }

    /**
     * @param User $user
     * @param Request $request
     * @Route("/reset/{id}", name="reset")
     * @return Response
     */
    public function reset (User $user, Request $request)
    {
        $submittedToken = $request->query->get('token');
        if ($this->isCsrfTokenValid('reset'.$user->getUsername(), $submittedToken)) {
            return $this->render('security/reset.html.twig', [
                'user' => $user
            ]);
        }
        return new Response('Erreur dans le token');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/resetting/{id}", name="resetting")
     */
    public function resetting (User $user, Request $request)
    {
        $submittedEmail = $request->request->get('_email');
        $submittedPwd = $request->request->get('_password');
        $submittedToken = $request->request->get('token');

        if ($this->isCsrfTokenValid($user->getPassword(), $submittedToken)) {
            $user->setEmail($submittedEmail);
            $user->setPassword($this->encoder->encodePassword($user, $submittedPwd));
            $this->em->flush();
            return $this->redirectToRoute('frontend');
            //Rajouter en JS un modal d'ouverture automatique pour confirmer la modification
        }
        return new Response('Vous essayez de violer le site, en cas de nouvelle tentative nous alerterons les forces de l\'ordre!');
    }
    
}
