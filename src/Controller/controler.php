<?php
// src/Controller/LuckyController.php
namespace App\Controller;
use App\Entity\Cours;
use App\Entity\Exos;
use App\Entity\Profs;
use App\Entity\Etudiants;
use App\Entity\Instructions;
use App\Entity\Reponses;
use Doctrine\ORM\EntityManagerInterface;



use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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

   /**
     * 
     * ====================  Charger la page d'acceil Ensegnat ======================
     * 
     */

    public function loadensmainpage()
    {   
        $user=$this->getUser();

        $mes_prof_repo = $this->getDoctrine()->getRepository(Profs::class);
        $mon_prof= ($mes_prof_repo->findBy(['user' => $user]))[0];

        $mes_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
        $mes_cours= $mes_cours_repo->findBy(['prof' => $mon_prof]);

        $nb_exo=0;
        foreach($mes_cours as $cours){
            $nb_exo+=count($cours->getExos());
        }
        return $this->render('ens/ensmainpage.html.twig',['nb_cours' => count($mes_cours),'nb_exos'=> $nb_exo,'prof'=>$mon_prof]);
    }

    /**
     * 
     * ====================  Cree un nouveau cours -- exercice -- voir les exercices ======================
     * 
     */

    public function loadnewcours(Request $request)
    {  
         $id_prof=$request->request->get('id_prof');

         $mes_prof_repo = $this->getDoctrine()->getRepository(Profs::class);
         $mon_prof= $mes_prof_repo->find((int)$id_prof);


        $mes_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
        $mes_cours= $mes_cours_repo->findBy(['prof' => (int)$id_prof]);

        return $this->render('ens/newcours.html.twig',['mes_cours' => $mes_cours,'prof'=>$mon_prof]);
    } 

    public function loadstatsens(Request $request)
    {   $id_prof=$request->request->get('id_prof');

        $mes_prof_repo = $this->getDoctrine()->getRepository(Profs::class);
        $mon_prof= $mes_prof_repo->find((int)$id_prof);

        $mes_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
        $mes_cours=  $mes_cours_repo->findBy(['prof' => (int)$id_prof]);

        $mes_etudiant_repo = $this->getDoctrine()->getRepository(Etudiants::class);
        $mes_etudiants= $mes_etudiant_repo->findAll();
        



        return $this->render('ens/statsens.html.twig',['mes_cours' =>$mes_cours,
                                                       'prof'=>$mon_prof,
                                                       'liste_etu'=>$mes_etudiants]);
    }
   
    /**
     * 
     * ====================  Charger la page d'acceil etudiant ======================
     * 
     */

    public function loadetumainpage()
    {
        $user=$this->getUser();
        $mes_etudiant_repo = $this->getDoctrine()->getRepository(Etudiants::class);
        $mon_etudiant= $mes_etudiant_repo->findBy(['user' => $user]);
        $mes_cours=$mon_etudiant[0]->getCours();
        $mes_tentative=$mon_etudiant[0]->getReponses();


        return $this->render('etu/etumainpage.html.twig',['nb_cours' => count($mes_cours),'nb_exos'=> count($mes_tentative),'etud'=>$mon_etudiant[0]]);
    }
     
 
       
    

  /**
     * 
     * ====================  Reponse au exercice  ======================
     * 
     */


    public function loadnewcoursetu(Request $request)
    {  
        $id_etu=$request->request->get('id_etu');
        $mes_etudiant_repo = $this->getDoctrine()->getRepository(Etudiants::class);
        $mes_etudiants= $mes_etudiant_repo->findBy(['id' => (int)$id_etu]);

        $mon_etu=$mes_etudiants[0];
        $mes_cours_inscri=$mon_etu->getCours();
        
        $mes_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
        $mes_cours= $mes_cours_repo->findAll();

        $diff=array_diff($mes_cours,$mes_cours_inscri->toArray());
        $cours_non_suivie=new ArrayCollection($diff);

        return $this->render('etu/newcoursetu.html.twig',['cours_non_suivie' =>$cours_non_suivie ,
                                                          'cours_suivie'=>$mes_cours_inscri,
                                                          'etud'=>$mon_etu]);
        
    }


    public function loadstatsetu(Request $request)
    {
        $id_etu=$request->request->get('id_etu');
        
        $mes_etudiant_repo = $this->getDoctrine()->getRepository(Etudiants::class);
        $mon_etudiant= $mes_etudiant_repo->find( (int)$id_etu);

        $mes_responses_repo = $this->getDoctrine()->getRepository(Reponses::class);
        $mes_reponse_vrais= $mes_responses_repo->findBy(['etudiant' => $mon_etudiant ,'note' =>1]);

        $mes_reponses=$mon_etudiant->getReponses();

        
        $note=0;
        $dernier_exo_r="";
        $dernier_exo_t="";
        if(!empty($mes_reponse_vrais) && !empty($mes_reponses) ){

        //------------ calcule de la note    
        $note=((float)count($mes_reponse_vrais)/(float)count($mes_reponses));
        //------------ les derniers exo 
        $dernier_exo_r=$mes_reponse_vrais[count($mes_reponse_vrais)-1]->getExo()->getTitre();
        $dernier_exo_t=$mes_reponses[count($mes_reponses)-1]->getExo()->getTitre();

        $note=round($note,2)*10;
        
          }

        
        
        $mes_cours=$mon_etudiant->getCours();
        return $this->render('etu/statsetu.html.twig',['total_resolue' =>count($mes_reponse_vrais),
                                                       'etud'=>$mon_etudiant,
                                                       'note'=>$note,
                                                       'dernier_exo_r'=>$dernier_exo_r,
                                                       'dernier_exo_t'=>$dernier_exo_t,
                                                       'mes_cours'=>$mes_cours]);
    }
    

   /**
     * 
     * ====================  Ajouter un Cours ======================
     * 
     */

    public function addcours(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $id_prof = $request->request->get('id_prof');
        $titre = $request->request->get('titre');
        $discription = $request->request->get('discription');


        $mon_prof_repo = $this->getDoctrine()->getRepository(Profs::class);
        $mon_prof= $mon_prof_repo->findBy(['id' =>(int)$id_prof]);
       // var_dump(count($mon_prof)); exit;


        $newcours= new Cours();

        $newcours->setNom($titre);
        $newcours->setContenu($discription);
        $newcours->setProf($mon_prof[0]);

        $entityManager->persist($newcours);
        $entityManager->flush();

        $mes_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
        $mes_cours= $mes_cours_repo->findBy(['prof' => $id_prof]);
        return $this->render('ens/newcours.html.twig',['mes_cours' => $mes_cours,'prof'=>$mon_prof[0]]);


    }

    /**
     * 
     * ====================  Suivre un Cours ======================
     * 
     */

    public function suivrecours(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cours_id = $request->request->get('cours_id');
        $etudiant_id = $request->request->get('etudiant_id');


        $mon_etudiant_repo = $this->getDoctrine()->getRepository(Etudiants::class);
        $mon_etudiant= $mon_etudiant_repo->find((int)$etudiant_id);

        $mon_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
        $mon_cours= $mon_cours_repo->find((int)$cours_id);
         
        $mon_etudiant->addCour($mon_cours);
        $entityManager->flush();

        $mes_cours= $mon_cours_repo->findAll();
        $mes_cours_inscri=$mon_etudiant->getCours();
        $diff=array_diff($mes_cours,$mes_cours_inscri->toArray());
        $cours_non_suivie=new ArrayCollection($diff);

        return $this->render('etu/newcoursetu.html.twig',['cours_non_suivie' =>$cours_non_suivie ,
                                                          'cours_suivie'=>$mes_cours_inscri,
                                                          'etud'=>$mon_etudiant]);

    }




    // ==================================== Partie  AJAX =======================================


    /**
     * 
     * ====================  Ajouter un exercice ======================
     * 
     */

    public function addexe(Request $request )
    {   
        if($request->isXmlHttpRequest())
        {
         
            $data = $request->request->get('my_nodes');
            $enonce= $request->request->get('enonce');
            $cours_id=$request->request->get('cours_id');
            $titre=$request->request->get('titre');


            $entityManager = $this->getDoctrine()->getManager();

            $mon_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
            $mon_cours= $mon_cours_repo->findBy(['id' =>(int)$cours_id]);

            $exo=new Exos();

            $exo->setTitre($titre);
            $exo->setContenu($enonce);
            $exo->setCour($mon_cours[0]);

            foreach($data as $instu_recu){
                $instu=new Instructions();
                $instu->setContenu($instu_recu['text']);
                $instu->setOrdreVrai($instu_recu['rang']);
                $instu->setOrdreFaux($instu_recu['pos']);

                $exo->addInstruction($instu);
            }

            $entityManager->persist($exo);
            $entityManager->flush();

            


            //print_r($data);
            return new Response('Bien ajouter');

        }
        return new Response('donner moi AJAX svp');

    }

    /**
     * 
     * ====================  Charger un exercice ======================
     * 
     */

    public function showexe(Request $request )
    {

        if($request->isXmlHttpRequest())
        {

            $cours_id = $request->request->get('crous_id');
            $mon_cours_repo = $this->getDoctrine()->getRepository(Cours::class);
            $mon_cours= $mon_cours_repo->findBy(['id' =>(int)$cours_id]);

            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($mon_cours[0], 'json',[
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);

            
            return new JsonResponse($jsonContent);

        }

        return new Response('donner moi AJAX svp');

    }

    /**
     * 
     * ====================  preparer un exercice ======================
     * 
     */

    public function getinstur(Request $request )
    {

        if($request->isXmlHttpRequest())
        {

            $exo_id = $request->request->get('id');
            $mon_exo_repo = $this->getDoctrine()->getRepository(Exos::class);
            $mon_exo= $mon_exo_repo->findBy(['id' =>(int)$exo_id]);
            $mes_instruction=$mon_exo[0]->getInstructions();

            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            $jsonContent = $serializer->serialize($mes_instruction, 'json',[
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);

            
            return new JsonResponse($jsonContent);

        }

        return new Response('donner moi AJAX svp');

    }


 /**
     * 
     * ====================  Sauvgarder une tentative ======================
     * 
     */

    public function savetentative(Request $request )
    {

        if($request->isXmlHttpRequest())
        {   
            $entityManager = $this->getDoctrine()->getManager();

            $exo_id = $request->request->get('exo');
            $etu_id=  $request->request->get('etu');
            $resultat=  $request->request->get('resulat');

            $mon_exo_repo = $this->getDoctrine()->getRepository(Exos::class);
            $mon_exo= $mon_exo_repo->find((int)$exo_id);

            $mon_etu_repo = $this->getDoctrine()->getRepository(Etudiants::class);
            $mon_etu= $mon_etu_repo->find((int)$etu_id);

            $mes_reponses_repo = $this->getDoctrine()->getRepository(Reponses::class);
            $mes_rep= $mes_reponses_repo->findBy(['etudiant' =>$mon_etu ,
                                                  'exo'=>$mon_exo,
                                                  'note'=>1]);

           if(count($mes_rep)<1)
           {
            $reponse=new Reponses();
            $reponse->setNote($resultat);
            $reponse->setExo($mon_exo);
            $reponse->setEtudiant($mon_etu);

            $entityManager->persist($reponse);
            $entityManager->flush();
            } 
            $message="";

            if($resultat){$message=" Tentative sauvgardé bravo pour la solution";}
            else{$message=" Tentative sauvgardé essayer une autre fois";}
            return new JsonResponse($message);

        }

        return new Response('donner moi AJAX svp');

    }


}
