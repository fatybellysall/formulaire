<?php

namespace App\Controller;

use App\Entity\PersonneEntity;
use App\Form\PersonneEntityType;
use App\Repository\PersonneEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonneEntityController extends AbstractController
{
    #[Route('/personne', name: 'app_personne_entity_index', methods: ['GET'])]
    public function index(PersonneEntityRepository $personneEntityRepository): Response
    {
        return $this->render('personne_entity/index.html.twig', [
            'personne_entities' => $personneEntityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_personne_entity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonneEntityRepository $personneEntityRepository): Response
    {
        $personneEntity = new PersonneEntity();
        $form = $this->createForm(PersonneEntityType::class, $personneEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneEntityRepository->save($personneEntity, true);

            return $this->redirectToRoute('app_personne_entity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne_entity/new.html.twig', [
            'personne_entity' => $personneEntity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personne_entity_show', methods: ['GET'])]
    public function show(PersonneEntity $personneEntity): Response
    {
        return $this->render('personne_entity/show.html.twig', [
            'personne_entity' => $personneEntity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_personne_entity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonneEntity $personneEntity, PersonneEntityRepository $personneEntityRepository): Response
    {
        $form = $this->createForm(PersonneEntityType::class, $personneEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneEntityRepository->save($personneEntity, true);

            return $this->redirectToRoute('app_personne_entity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne_entity/edit.html.twig', [
            'personne_entity' => $personneEntity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personne_entity_delete', methods: ['POST'])]
    public function delete(Request $request, PersonneEntity $personneEntity, PersonneEntityRepository $personneEntityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personneEntity->getId(), $request->request->get('_token'))) {
            $personneEntityRepository->remove($personneEntity, true);
        }

        return $this->redirectToRoute('app_personne_entity_index', [], Response::HTTP_SEE_OTHER);
    }
}
