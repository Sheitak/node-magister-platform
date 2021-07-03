<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PlatformController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('platform/home.html.twig', [
            'controller_name' => 'PlatformController',
        ]);
    }

    /**
     * @Route("/account", name="account")
     */
    public function account(): Response
    {
        return $this->render('platform/account.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to(Address::fromString('StakeShareTeam <stakesharessx@gmail.com>'))
                ->subject($contact->getSubject())
                ->text($contact->getMessage())
                ->htmlTemplate('emails/message.html.twig')
                ->context([
                    'useremail' => $contact->getEmail(),
                    'text' => $contact->getMessage(),
                    'pseudo' => $contact->getPseudo(),
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Great ! Your mail has been sent successfully');
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $errorSend) {
            }

            return $this->redirectToRoute('contact');
        }

        return $this->render('platform/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
