<?php


namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/{slug}", name="categorie")
     */
    public function allCategorie(Categorie $categorie,
                                 CategorieRepository $categorieRepository,
                                 ArticleRepository $articleRepository)
    {
        return $this->render('blog/articles.html.twig', [
            'categories' => $categorieRepository->findAll(), // menu gauche
            'articles' => $categorie->getArticles(), // affichage article
            'current_categorie' => $categorie,
        ]);
    }
}
