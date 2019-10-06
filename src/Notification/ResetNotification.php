<?php
namespace App\Notification;

use Twig\Environment;
use App\Entity\User;

class ResetNotification
{

    private $mailer;

    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function send(User $user, $token)
    {
        $message = (new \Swift_Message('Snowtricks : Réinitialisation du mot de passe de '.$user->getFirstname()))
            ->setFrom('noreply@snowtricks.com')
            ->setTo($user->getEmail())
            ->setReplyTo('noreply@snowtricks.com')
            ->setBody($this->renderer->render('emails/send.html.twig', [
                'user' => $user,
                'token' => $token,
            ]), 'text/html');
        $this->mailer->send($message);
    }

}