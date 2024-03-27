<?php

namespace App\Controller\Admin;

use App\Entity\Departements;
use App\Entity\villes;
use App\Form\DepartementsType;
use App\Repository\DepartementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;


class DepartementsController extends AbstractController
{

    /**
     * @Route("/admin/departements", name="departements", methods={"GET"})
     */
    public function index(DepartementsRepository $departementsRepository): Response
    {
        return $this->render('admin/departements/index.html.twig', [
            'departements' => $departementsRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/departements/new", name="departements_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,DepartementsRepository $departementsRepository): Response
    {
        $departement = new Departements();

        $form = $this->createForm(DepartementsType::class, $departement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $titre_departement = $form->getData()->getTitre();
            $is_existe_departement = $departementsRepository->findDepartementByTitre($titre_departement);

           if($is_existe_departement)
           {
                $this->addFlash('error', 'Une région est déjà existe avec ce titre');
                // $form = $this->createForm(DepartementsType::class, $departement, array('titre'=>$titre_departement));
                // $form->handleRequest($request);
               // return $this->redirectToRoute('departements_new', [], Response::HTTP_SEE_OTHER);
               return $this->renderForm('admin/departements/new.html.twig', [
                'form' => $form,
              ]);

           }
           else{
                $entityManager->persist($departement);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('departements', [], Response::HTTP_SEE_OTHER);
           }

       }

        return $this->renderForm('admin/departements/new.html.twig', [
            'form' => $form
        ]);
    }

     /**
     * @Route("/admin/departements/deleteSelected", name="departements_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, DepartementsRepository $departementsRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $departement = $departementsRepository->find($element);
            $entityManager->remove($departement);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('departements', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/admin/departements/{id}", name="departements_show", methods={"GET"})
     */
    // public function show(Departements $departement): Response
    // {
    //     return $this->render('admin/departements/show.html.twig', [
    //         'departement' => $departement,
    //     ]);
    // }

    /**
     * @Route("/admin/departements/{id}/edit", name="departements_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Departements $departement, EntityManagerInterface $entityManager,DepartementsRepository $departementsRepository): Response
    {
        $form = $this->createForm(DepartementsType::class, $departement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre_departement = $form->getData()->getTitre();
            $id_departement = $form->getData()->getId();
            $is_existe_departement = $departementsRepository->findDepartementByIdTitre($id_departement,$titre_departement);
            if($is_existe_departement)
            {
                $this->addFlash('error', 'Une région est déjà existe avec ce titre');
                return $this->renderForm('admin/departements/new.html.twig', [
                    'form' => $form,
                  ]);
            }
            else{
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('departements', [], Response::HTTP_SEE_OTHER);
            }  
        }

        return $this->renderForm('admin/departements/edit.html.twig', [
            'departement' => $departement,
            'form' => $form,
            'step_update' => 1
        ]);
    }

    /**
     * @Route("/admin/departements/{id}", name="departements_delete",  methods={"GET", "POST"})
     */
    public function delete(Request $request, Departements $departement, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($departement);
        $entityManager->flush();
        $this->addFlash('success', 'Département supprimée avec succés');
        return $this->redirectToRoute('departements', [], Response::HTTP_SEE_OTHER);
    }

   
}
