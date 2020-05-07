<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class controler extends AbstractController
{
    public function loadhomepage()
    {
        return $this->render('login.html.twig',['content' => ""]);
    }

    public function loadregister()
    {
        return $this->render('register.html.twig',['content' => ""]);
    }  

    public function loadensmainpage()
    {
        return $this->render('ens/ensmainpage.html.twig',['content' => ""]);
    }

   
    public function loadnewcours()
    {
        return $this->render('ens/newcours.html.twig',['content' => ""]);
    } 

    public function loadstatsens()
    {
        return $this->render('ens/statsens.html.twig',['content' => ""]);
    }

    public function loadetumainpage()
    {
        return $this->render('etu/etumainpage.html.twig',['content' => ""]);
    }

    public function loadnewcoursetu()
    {
        return $this->render('etu/newcoursetu.html.twig',['content' => ""]);
    }

    public function loadstatsetu()
    {
        return $this->render('etu/statsetu.html.twig',['content' => ""]);
    }
    
}
