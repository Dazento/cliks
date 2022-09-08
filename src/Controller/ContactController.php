<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if (empty($contactForm['honeypot']->getData())) {
            if ($contactForm->isSubmitted() && $contactForm->isValid()) {
                $contact = $contactForm->getData();
                $email = (new TemplatedEmail())
                    ->from(new Address($contact['email'], $contact['firstname'] . ' ' . $contact['lastname'])) // expéditeur
                    ->to(new Address('dylanbury.pro@gmail.com')) // destinateur
                    ->replyTo(new Address($contact['email'], $contact['firstname'] . ' ' . $contact['lastname']))
                    ->subject($contact['subject'])
                    ->htmlTemplate('contact/contactEmail.html.twig')
                    ->context([
                        'firstname' => $contact['firstname'],
                        'lastname' => $contact['lastname'],
                        'subject' => $contact['subject'],
                        'message' => $contact['message'],
                        'emailAdress' => $contact['email'],
                    ]);
                    $mailer->send($email);
                    $this->addFlash('succes', 'Votre message a bien été envoyé');
                    return $this->redirectToRoute('contact');
            }
        } else {

        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView()
        ]);
    }
}
