<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/mailer", name="admin_mailer_")
 */
class MailerController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('admin/mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    /**
     * @Route("/email", name="email")
     */
    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            // defining the email address and name as a string
            // (the format must match: 'Name <email@example.com>')
            ->from(Address::create('Fabien Potencier <fabien@example.com>'))
            ->to('you@example.com')
            ->cc('cc@example.com')
            ->bcc('bcc@example.com')
            ->replyTo('fabien@example.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>')
        ;

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
            dump($e->getDebug());

            return new Response(
                'Email NOT sent'
            );
        }

        return new Response(
            'Email was sent'
        );
    }
}
