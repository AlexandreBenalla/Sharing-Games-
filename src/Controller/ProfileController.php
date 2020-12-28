<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvents;



class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="profile")
     */

    public function index(User $cur_profile,Request $request,SluggerInterface $slugger ,UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
        $repo =$this->getDoctrine()->getRepository(User::class);

        $form =$this->createFormBuilder($cur_profile)
            ->add('email',EmailType::class,[
                'required'=>false,
            ])

            ->add('Password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label'=> "Mot de passe",
                'required'=>false,
                'mapped'=>false,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('c_password',PasswordType::class,[
                'label' => "Confimer mot de passe",
                'required'=>false,
            ])

            ->add('name', TextType::class,[
                'required'=>false,
                'label'=>"Pseudonyme",
            ])
            ->add('image',FileType::class,[
                'label' => 'Image',
                'mapped' =>false,
                'required'=>false,
                'constraints' => [
                    new File([
                        'maxSize' => '3M',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                        ]
                    ])
                ]
            ])
            ->add('save',SubmitType::class,[
                'label' => "Modifier",
            ])




            ->getForm();
            $form->handleRequest($request);


        if ($form->isSubmitted() &&
            $form->isValid()&&
            $form->get("Password")->getData()==$form->get("c_password")->getData() ) {

                if ($form->get('image')->getData()){
                    $originalfilename=pathinfo($form->get('image')->getData()->getClientOriginalName(),PATHINFO_FILENAME);
                    $safefilename = $slugger->slug($originalfilename);
                    $newfilename = $safefilename.'-'.uniqid().'.'.$form->get('image')->getData()->guessExtension();
                    try {
                        $form->get('image')->getData()->move(
                            $this->getParameter('profile_images'),
                            $newfilename
                        );
                    }catch (FileException $e){

                    }
                    $cur_profile->setImgLink($newfilename);
                }
                if($form->get('name')->getData()){
                    $cur_profile->setName($form->get('name')->getData());
                }
                if($form->get('email')->getData()){
                    $cur_profile->setEmail($form->get('email')->getData());
                }

                if ($form->get('Password')->getData()){
                    $hash= $passwordEncoder->encodePassword($user,$form->get('Password')->getData());
                    $cur_profile->setPassword($hash);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cur_profile);
            $entityManager->flush();
            return $this->redirectToRoute('profile',['id'=>$cur_profile->getId()]);
        }
    return $this->render('profile/index.html.twig', [
        'cur_profile' => $cur_profile,
        'form' => $form->createView(),
    ]);

    }
}
