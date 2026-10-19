<?php

namespace App\Controller;

use App\Enum\ContactSubject;
use App\Form\ContactType;
use App\Model\ContactRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    public function __construct(
        #[Autowire(env: 'APP_CONTACT_EMAIL')]
        private readonly string $contactEmail,
    ) {
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $contact = new ContactRequest();
        // Permet de pré-sélectionner le sujet depuis un lien, ex. /contact?sujet=conference
        $contact->subject = ContactSubject::tryFrom($request->query->getString('sujet'));

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mailer->send(
                (new Email())
                    ->from($this->contactEmail)
                    ->to($this->contactEmail)
                    ->replyTo(new Address($contact->email, $contact->name))
                    ->subject(sprintf('[Contact] %s — %s', $contact->subject->label(), $contact->name))
                    ->text($this->renderView('contact/email.txt.twig', ['contact' => $contact]))
            );

            $this->addFlash('success', 'Merci! Votre message a bien été envoyé, nous vous répondrons rapidement.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
