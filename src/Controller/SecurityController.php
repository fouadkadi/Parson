<?php

namespace App\Controller;

use App\Entity\Profs;
use App\Entity\Users;
use App\Entity\Etudiants;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{



    /**
     * @Route("/inscription", name="security_insc")
     */
    public function registration(Request $request , EntityManagerInterface $manager ,UserPasswordEncoderInterface $mdph){

        $user = new Users();

        $form = $this->createForm(RegistrationType::class,$user);

        $form->handlerequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $new_pass = $mdph->encodePassword($user,$user->getPassword());
            $user->setPassword($new_pass);
            $p=new Profs();
            $e=new Etudiants();
            if($user->getType()==true)
            {
                $p->setNom($user->getNom());
                $p->setPassword($new_pass);
                $p->setUser($user);
                $p->load($manager,$p);
            }
            else
            {
                $e->setNom($user->getNom());
                $e->setPassword($new_pass);
                $e->setUser($user);
                $e->load($manager,$e);
            }

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('security_conn');
        }
        return $this->render('register.html.twig',[
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/" ,name = "security_conn")
     */
    public function login(){

        return $this-> render('login.html.twig');
    }
    /**
     * @Route(" /logout ", name= "security_deconn")
     */
  public function logout() {
  }

/**
 * @Route(" /redirect",name="redirect")
 */
  public function redir(){

    $user=$this->getUser();
    if($user->getType()==true){

        return $this->forward('App\Controller\controler::loadensmainpage');


    }else{
        return $this->forward('App\Controller\controler::loadetumainpage');

    }


  }


}
