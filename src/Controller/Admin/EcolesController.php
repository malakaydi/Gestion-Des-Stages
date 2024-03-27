<?php

namespace App\Controller\Admin;

use App\Entity\Ecoles;
use App\Form\EcolesType;
use App\Repository\EcolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EcolesController extends AbstractController
{
    /**
     * @Route("/admin/ecoles", name="ecoles", methods={"GET"})
     */
    public function index(EcolesRepository $ecolesRepository): Response
    {
        return $this->render('admin/ecoles/index.html.twig', [
            'ecoles' => $ecolesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/ecoles/new", name="ecoles_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,EcolesRepository $ecolesRepository): Response
    {
        $ecole = new Ecoles();
        $form = $this->createForm(EcolesType::class, $ecole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->getData()->getTitre();
            $is_existe_ecole = $ecolesRepository->findEcoleByTitre($titre);
            if($is_existe_ecole)
            {
                $this->addFlash('error', 'une école est déjà existe avec ce titre');
                return $this->renderForm('admin/ecoles/new.html.twig', [
                    'form' => $form,
                  ]);
            }
            else{
                $entityManager->persist($ecole);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('ecoles', [], Response::HTTP_SEE_OTHER);
            } 
        }
        return $this->renderForm('admin/ecoles/new.html.twig', [
            'ecole' => $ecole,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/ecoles/updateStatus", name="ecoles_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager, EcolesRepository $ecolesRepository): Response
    {     
        $idEcole = (int)$request->request->get('idEcole');
        $newStatus = (int)$request->request->get('status');
        $ecole = $ecolesRepository->find($idEcole);
        $ecole->setStatus($newStatus);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }

     /**
     * @Route("/admin/ecoles/activeSelected", name="ecoles_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager, EcolesRepository $ecolesRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $status = (bool) $request->query->get('status');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ecole = $ecolesRepository->find($element);
            $ecole->setStatus($status);
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('ecoles', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/admin/ecoles/deleteSelected", name="ecoles_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, EcolesRepository $ecolesRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ecole = $ecolesRepository->find($element);
            $entityManager->remove($ecole);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('ecoles', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("admin/ecoles/{id}/edit", name="ecoles_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Ecoles $ecole, EntityManagerInterface $entityManager): Response
    {
      
        $form = $this->createForm(EcolesType::class, $ecole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ecoles', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/ecoles/edit.html.twig', [
            'ecole' => $ecole,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/ecoles/{id}", name="ecoles_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Ecoles $ecole, EntityManagerInterface $entityManager): Response
    {
        
        $entityManager->remove($ecole);
        $entityManager->flush();
        $this->addFlash('success', 'Ecole supprimée avec succés');

        return $this->redirectToRoute('ecoles', [], Response::HTTP_SEE_OTHER);
    }
}
