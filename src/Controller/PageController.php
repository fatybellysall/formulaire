<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\PersonnesFormType;
use App\Entity\PersonneEntity;
use App\Form\ModifierFormType;
use App\Entity\Modifier;
use App\Controller\createView;
// use App\Controller\EntityManagerInterface;




class PageController extends AbstractController
{

    private $mr;

    private $entityManager;

    public function __construct(ManagerRegistry $mr) {
        $this->mr = $mr;
        $this->entityManager = $this->mr->getManager();
    }

    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {

        // $PersonneEntity = $this->getRepository(PersonneEntity::class)->findALL();
        return $this->render('page/index.html.twig');
    }

    #[Route('/ajout', name: 'app_ajoutPersonne')]
    public function ajoutPersonne(Request $request)
    {

        //on crée un "un nouveau persones"
        $PersonneEntity = new PersonneEntity();
        
        $entityManager=$this->mr->getManager();

        //on crée un formulaire
        $personneForm = $this->createForm(PersonnesFormType::class, $PersonneEntity);

      //on traite la formulaire
       $personneForm->handleRequest($request);


        if($personneForm->isSubmitted() &&$personneForm->isValid()){

            $PersonneEntity =$personneForm->getData();

           $entityManager->persist($PersonneEntity);


           $entityManager-> flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('page/ajoutPersonne.html.twig',[

            'personneForm' =>$personneForm->createView()
        ]);
        
    }

    #[Route('/modifier', name: 'app_modifierPersonne')]
    public function modifierPersonne(Request $request)
    {

        //on crée un "un nouveau persones"
        $Modifier = new Modifier();
        $entityManager=$this->mr->getManager();

        //on crée un formulaire
        $modifierForm = $this->createForm(ModifierFormType::class, $Modifier);

      //on traite la formulaire
       $modifierForm->handleRequest($request);


        if($modifierForm->isSubmitted() &&$modifierForm->isValid()){

            $Modifier =$modifierForm->getData();

           $entityManager->persist($Modifier);


           $entityManager-> flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('page/modifierPersonne.html.twig',[

            'modifierForm' =>$modifierForm->createView()
        ]);
        
    }

    #[Route ('/liste', name: 'app_listePersonne')]
    public function List(ManagerRegistry $mr): Response
    {
        $allModifier = $mr->getRepository(Modifier::class)->findALL();

        return $this-> render ('page/listePersonne.html.twig',[
            
            'allModifier' => $allModifier

        ]);
    }
    

    

}