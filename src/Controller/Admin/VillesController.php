<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Departements;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Villes;
use App\Form\VillesType;
use App\Repository\VillesRepository;
use Doctrine\ORM\EntityManagerInterface;



class VillesController extends AbstractController
{
    
    /**
     * @Route("/admin/villes", name="villes")
     */
    public function index(VillesRepository $villesRepository): Response
    {
        return $this->render('admin/villes/index.html.twig', [
            'villes' => $villesRepository->findAll()
        ]);
    }
     /**
     * @Route("/admin/villes/new", name="villes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,VillesRepository $VillesRepository): Response
    {
        $ville = new Villes();
        $form = $this->createForm(VillesType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $titre_ville = $form->getData()->getTitre();
            $departement= $form->getData()->getDepartements();
            $is_existe_ville = $VillesRepository->findVilleByTitre($titre_ville,$departement->getId());
           if($is_existe_ville)
           {
              $this->addFlash('error', 'Une ville est déjà existe avec ce titre');
               return $this->renderForm('admin/villes/new.html.twig', [
                'form' => $form,
              ]);

           }
           else{
                $entityManager->persist($ville);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('villes', [], Response::HTTP_SEE_OTHER);
           }

       }
       
        return $this->renderForm('admin/villes/new.html.twig', [
            'ville' => $ville,
            'form' => $form
        ]);
    }
    
     /**
     * @Route("/admin/villes/deleteSelected", name="villes_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, VillesRepository $VillesRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ville = $VillesRepository->find($element);
            $entityManager->remove($ville);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('villes', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @Route("/admin/villes/{id}/edit", name="villes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Villes $ville, EntityManagerInterface $entityManager, VillesRepository $VillesRepository): Response
    {
        $form = $this->createForm(VillesType::class, $ville);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre_ville = $form->getData()->getTitre();
            $id_ville = $form->getData()->getId();
            $departement= $form->getData()->getDepartements();
            $is_existe_ville = $VillesRepository->findVilleByIdTitre($id_ville,$titre_ville,$departement->getId());
            if($is_existe_ville)
            {
               $this->addFlash('error', 'Une ville est déjà existe avec ce titre');
                return $this->renderForm('admin/villes/new.html.twig', [
                 'form' => $form,
               ]);
 
            }
            else{
                 $entityManager->flush();
                 $this->addFlash('success', 'Mise à jour effectuée avec succés');
                 return $this->redirectToRoute('villes', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('admin/villes/edit.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/villes/{id}", name="villes_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Villes $ville, EntityManagerInterface $entityManager): Response
    {
        
        $entityManager->remove($ville);
        $entityManager->flush();
        $this->addFlash('success', 'Ville supprimée avec succés');
        return $this->redirectToRoute('villes', [], Response::HTTP_SEE_OTHER);
    }
}
