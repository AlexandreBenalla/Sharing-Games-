<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(User $cur_profile=null): Response
    {
        if ($cur_profile){
            return $this->redirectToRoute('feed');
        }
        return $this->render('acceuil/index.html.twig');
    }



}

