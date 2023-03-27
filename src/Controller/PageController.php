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
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
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

        return $this->render('page/listePersonne.html.twig',[

            'personneForm' =>$personneForm->createView()
        ]);
    }
}
