<?php


namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Bridge\Mailgun\Transport\MailgunSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/{slug}", name="categorie")
     */
    public function allCategorie(Categorie $categorie,
                                 CategorieRepository $categorieRepository,
                                 ArticleRepository $articleRepository,
                                 MailerInterface $mailer,
                                 Request $request)
    {
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

        return $this->render('blog/articles.html.twig', [
            'categories' => $categorieRepository->findAll(), // menu gauche
            'articles' => $categorie->getArticles(), // affichage article
            'current_categorie' => $categorie,
            'contact' => $contactForm->createView(),
        ]);
    }
}
