<?php


namespace App\Controller;


use App\Entity\Article;
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

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function accueil(ArticleRepository $articleRepository,
                            CategorieRepository $categorieRepository,
                            MailerInterface $mailer,
                            Request $request)
    {
        $categories = $categorieRepository->findAll();
        $dates = $articleRepository->findByDerArticle();

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

        return $this->render('blog/blog.html.twig', [
            'controler_name' => 'BlogController',
            'dates' => $dates,
            'categories' => $categories,
            'contact' => $contactForm->createView(),
        ]);
    }

    /**
     * @Route("/articles", name="articles")
     */
    public function all(ArticleRepository $articleRepository,
                        CategorieRepository $categorieRepository,
                        MailerInterface $mailer,
                        Request $request)
    {
        $categories = $categorieRepository->findAll();
        $articles = $articleRepository->findAll();

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
            'controler_name' => 'BlogController',
            'articles' => $articles,
            'categories' => $categories,
            'contact' => $contactForm->createView(),
        ]);
    }

    /**
     * @Route("/article/{slug}", name="article")
     */
    public function show($slug,
                         ArticleRepository $articleRepository,
                         CategorieRepository $categorieRepository,
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

        /**
         * @var Article $article
         */
        $article = $articleRepository->findOneBySlug($slug);
        $categories = $categorieRepository->findAll();
        if (!$article) {
            throw $this->createNotFoundException('Cette article n\'existe pas');
        }

        return $this->render('blog/show_article.html.twig', [
            'controler_name' => 'BlogController',
            'article' => $article,
            'categories' => $categories,
            'contact' => $contactForm->createView(),
        ]);
    }
}
