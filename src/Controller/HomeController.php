<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    private $articleRepository;

    private $categoryRepository;

    public function __construct(ArticleRepository $articleRepository,CategoryRepository $categoryRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
       
        $articles = $this->articleRepository->findAll();

         return $this->render("home/index.html.twig", [
            'articles' => $articles,
            'categories' => $this->categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("show/{id}", name="show_article")
     */
    public function show(?Article $article): Response
    {
      
       if(!$article){
          return  $this->redirectToRoute('home');
    }
    return $this->render("show/index.html.twig", [
            'article' => $article
        ]);
    }

    /**
     * @Route("showArticles{id}", name="show_article_category")
     */
    public function showArticle(?Category $category): Response
    {
     
    if($category){
         $articles = $category->getArticles()->getValues();     // Au lié de récupérer la collection, on récupère les values
     }else{
        return  $this->redirectToRoute('home');
     }
     return $this->render("home/index.html.twig", [
        'articles' => $articles,
        'categories' => $this->categoryRepository->findAll()
    ]);
      
    
    }
}
