<?php
namespace App\Notification;

use App\Entity\User;
use Twig\Environment;

class ValidationNotification {
    
    private $mailer;
    
    private $renderer;
    
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify (User $user, $token) {

        $message = (new \Swift_Message('Snowtricks : Validation du compte de '.$user->getFirstname()))
            ->setFrom('noreply@snowtricks.com')
            ->setTo($user->getEmail())
            ->setReplyTo('noreply@snowtricks.com')
            ->setBody($this->renderer->render('emails/validation.html.twig', [
                'user' => $user,
                'token' => $token,
            ]), 'text/html');
        $this->mailer->send($message);
    }
}