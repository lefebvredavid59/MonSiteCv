<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\CompetenceRepository;
use App\Repository\ContactRepository;
use App\Repository\ExperienceRepository;
use App\Repository\MoiRepository;
use App\Repository\ProjetRepository;
use App\Repository\RealisationRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Bridge\Mailgun\Transport\MailgunSmtpTransport;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function index(MoiRepository $moiRepository,
                          ProjetRepository $projetRepository,
                          CompetenceRepository $competenceRepository,
                          ExperienceRepository $experienceRepository,
                          RealisationRepository $realisationRepository,
                          MailerInterface $mailer,
                          Request $request)
    {
        $mois = $moiRepository->findAll();
        $projets = $projetRepository->findAll();
        $competences = $competenceRepository->findAll();
        $experiences = $experienceRepository->findAll();
        $realisations = $realisationRepository->findAll();


        // formulaire de contact


        $transport = new MailgunSmtpTransport('', '');
        $mailer = new Mailer($transport);

        $contact = new Contact();
        $contactForm = $this->createForm(ContactType::class,$contact);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new Email())
                ->from($contact->getEmail())
                ->to('dlefebvredev@gmail.com')
                ->subject($contact->getRaison())
//                ->htmlTemplate('mail/confirmMail.html.twig')
                ->text($contact->getMessage());

            $mailer->send($email);

            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->render('accueil/accueil.html.twig', [
            'controller_name' => 'AccueilController',
            'mois' => $mois,
            'projets' => $projets,
            'competences' => $competences,
            'experiences' => $experiences,
            'realisations' => $realisations,
            'contact' => $contactForm->createView(),
        ]);
    }
}
