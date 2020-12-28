<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class LogonHomeController extends AbstractController
{
    /**
     * @Route("/feed", name="acceuil")
     */
    public function index(ArticleRepository $repo): Response
    {
        $article = $repo->findAll();
        return $this->render('logon_home/show.html.twig', [
            'articles' => $article
        ]);
    }
}