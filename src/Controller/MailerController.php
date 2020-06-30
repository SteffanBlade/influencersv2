<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/email/{email}")
     */
    public function sendEmail(MailerInterface $mailer,string $mail)
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to($mail)
//->cc('cc@example.com')
//->bcc('bcc@example.com')
//->replyTo('fabien@example.com')
//->priority(Email::PRIORITY_HIGH)
            ->subject('Test the mailer!')
            ->text('Some code here')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);


    }
}