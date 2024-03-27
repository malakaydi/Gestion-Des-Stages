<?php

namespace App\Controller\Admin;

use App\Entity\Fonctions;
use App\Form\FonctionsType;
use App\Repository\FonctionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FonctionsController extends AbstractController
{
    /**
     * @Route("/admin/fonctions", name="fonctions", methods={"GET"})
     */
    public function index(FonctionsRepository $fonctionsRepository): Response
    {
        return $this->render('admin/fonctions/index.html.twig', [
            'fonctions' => $fonctionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/fonctions/new", name="fonctions_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, FonctionsRepository $fonctionsRepository): Response
    {
        $fonction = new Fonctions();
        $form = $this->createForm(FonctionsType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $titre_fonction = $form->getData()->getTitre();
            $category= $form->getData()->getCategorieId();
            $is_existe_fonction = $fonctionsRepository->findFonctionByTitre($titre_fonction,$category->getId());
           if($is_existe_fonction)
           {
              $this->addFlash('error', 'Une fonction est déjà existe avec ce titre');
               return $this->renderForm('admin/fonctions/new.html.twig', [
                'form' => $form,
              ]);

           }
           else{
                $entityManager->persist($fonction);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('fonctions', [], Response::HTTP_SEE_OTHER);
           }

       }

        return $this->renderForm('admin/fonctions/new.html.twig', [
            'fonction' => $fonction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/fonctions/updateStatus", name="fonctions_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager, FonctionsRepository $fonctionsRepository): Response
    {     
        $idFonction = (int)$request->request->get('idFonction');
        $newStatus = (int)$request->request->get('status');
        $fonction = $fonctionsRepository->find($idFonction);
        $fonction->setStatus($newStatus);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }

     /**
     * @Route("/admin/fonctions/activeSelected", name="fonctions_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager, FonctionsRepository $fonctionsRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $status = (bool) $request->query->get('status');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ecole = $fonctionsRepository->find($element);
            $ecole->setStatus($status);
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('fonctions', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/admin/fonctions/deleteSelected", name="fonctions_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, FonctionsRepository $fonctionsRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ville = $fonctionsRepository->find($element);
            $entityManager->remove($ville);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('fonctions', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/admin/fonctions/{id}/edit", name="fonctions_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Fonctions $fonction, EntityManagerInterface $entityManager, FonctionsRepository $fonctionsRepository): Response
    {
        $form = $this->createForm(FonctionsType::class, $fonction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id_fonction = $form->getData()->getId();
            $titre_fonction = $form->getData()->getTitre();
            $category= $form->getData()->getCategorieId();
            $is_existe_fonction =  $fonctionsRepository->findFonctionByIdTitre($id_fonction,$titre_fonction,$category->getId());;
           if($is_existe_fonction)
           {
              $this->addFlash('error', 'Une fonction est déjà existe avec ce titre');
               return $this->renderForm('admin/fonctions/new.html.twig', [
                'form' => $form,
              ]);

           }
           else{
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('fonctions', [], Response::HTTP_SEE_OTHER);
           }

       }

        return $this->renderForm('admin/fonctions/edit.html.twig', [
            'fonction' => $fonction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/fonctions/{id}", name="fonctions_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Fonctions $fonction, EntityManagerInterface $entityManager): Response
    {
    
        $entityManager->remove($fonction);
        $entityManager->flush();
        $this->addFlash('success', 'Fonction supprimée avec succés');
        return $this->redirectToRoute('fonctions', [], Response::HTTP_SEE_OTHER);
    }
}
