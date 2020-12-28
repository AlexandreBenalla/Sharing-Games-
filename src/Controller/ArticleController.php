<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\ChoiceList\ArrayChoiceList;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\Validator\Constraints\Url;
class ArticleController extends AbstractController
{
    /**
     * @Route("/article/new", name="article_create")
     * @Route("/article/{id}/edit", name="blog_edit")
     */
        public function form(Article $article= null,Request $request, EntityManagerInterface $manager){
            if(!$article){$article = new Article();}
            $form = $this->createFormBuilder($article)
                         ->add('title',TextType::class,[
                             'attr' => [
                                 'placeholder' => "Titre de l'article",
                                 'class' => 'form-control'
                             ]
                         ])
                         ->add('content',TextareaType::class,[
                             'attr' => [
                                 'placeholder' => "Contenu de l'article",
                                 'class' => 'form-control'
                             ]
                         ])
                         ->add('image', UrlType::class,[
                             'attr' => [
                                 'placeholder' => "URL de l'image",
                                 'class' => 'form-control'
                             ]
                         ])

                         ->add('DownLoadLink',UrlType::class,[
                                 'attr' => [
                                     'placeholder' => "URL du téléchargement",
                                     'class' => 'form-control',
                                     'label'=> 'Lien de téléchargement'
                                 ]
                             ]
                         )
                         ->add('save',SubmitType::class,[
                             'label' => 'Enregistrer'
                         ])
                /*
                         ->add('categories',EntityType::class,[
                             'class'=>Category::class,
                             'choice_label' => 'title'
                         ])
                */
                         ->getForm();


            $form->handleRequest($request);
            if($form->isSubmitted()&& $form->isValid()){
                if(!$article->getId()){
                    $article->setCreateAt(new \DateTime());
                }
                $manager->persist($article);
                $manager->flush();
                return $this->redirectToRoute('article_show',['id' => $article->getId()]);
            }
            return $this->render('article/create.html.twig',[
                'formArticle' => $form->createView(),
            ]);
        }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(Article $article,Request $request, EntityManagerInterface $manager): Response
    {       $comment = new Comment();
        $form = $this->createFormBuilder($comment)
                     ->add('author')
                     ->add('content')
                     ->getForm()
        ;
        $form->handleRequest($request)
        ;
        if($form->isSubmitted() &&$form->isValid()){
            $comment->setCreateAt(new \DateTime())
                    ->setArticle($article);

            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('article_show',['id'=> $article->getId()]);

        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'commentForm'=> $form->createView()
            ]);
    }



}
