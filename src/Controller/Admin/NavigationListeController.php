<?php

namespace App\Controller\Admin;

use App\Entity\Navigation;
use App\Entity\NavigationListe;
use App\Form\NavigationListeType;
use App\Repository\NavigationListeRepository;
use App\Repository\NavigationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class NavigationListeController extends AbstractController
{
    /**
     * @Route("admin/navigation_liste/", name="navigation_liste", methods={"GET"})
     */
    public function index(Request $request,NavigationListeRepository $navigationListeRepository,NavigationRepository $navigationRepository): Response
    {    $navigation= $request->query->get('id');
       
        return $this->render('admin/navigation_liste/index.html.twig', [
            'navigation_liste' => $navigationListeRepository->findByNav($navigation),
            'ItemsNavigations' => $navigationRepository->findById($navigation),
           
            
        ]);
    }


 
    /**
     * @Route("admin/navigation_liste/new", name="navigation_liste_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, NavigationListeRepository $navigationListeRepository): Response
    {
        $navigationListe = new NavigationListe();
        $form = $this->createForm(NavigationListeType::class, $navigationListe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->getData()->getTitre();
            $is_existe_secteur = $navigationListeRepository->findnavigationByTitre($titre);
            if($is_existe_secteur)
            {
                $this->addFlash('error', 'Un secteur est déjà existe avec ce titre');
                return $this->renderForm('admin/navigation_liste/new.html.twig', [
                    'form' => $form,
                  ]);
            }
            $id_navigation = $form->getData()->getNavigation()->getId();
           
            $entityManager->persist($navigationListe);
            $entityManager->flush();
            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );
            return $this->redirectToRoute('navigation_items', ['id'=>$id_navigation], Response::HTTP_SEE_OTHER);
        }
            
        
        return $this->renderForm('admin/navigation_liste/new.html.twig', [
            'navigationListe' => $navigationListe,
            'form' => $form,
        ]);
    }
     /**
     * @Route("/admin/navigation_liste/updateStatus", name="navigation_liste_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager, navigationListeRepository $navigationListeRepository): Response
    {     
        $idNavigationListe = (int)$request->request->get('idNavigationListe');
        $newActif = (int)$request->request->get('actif');
        $navigationListe = $navigationListeRepository->find($idNavigationListe);
        $navigationListe->setActif($newActif);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }

     /**
     * @Route("/admin/navigation_liste/activeSelected", name="navigation_liste_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager, navigationListeRepository $navigationListeRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $id_navigation =$request->query->get('id');
        $actif = (bool) $request->query->get('actif');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $navigationListe = $navigationListeRepository->find($element);
            $navigationListe->setActif($actif);
         }
        //  $id_navigation = $form->getData()->getNavigation()->getId();
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('navigation_items', ['id'=>$id_navigation], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/admin/navigation_liste/deleteSelected", name="navigation_liste_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, navigationListeRepository $navigationListeRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $id_navigation =$request->query->get('id');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $navigationListe = $navigationListeRepository->find($element);
            $entityManager->remove($navigationListe);  
         }
         
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('navigation_liste', ['id'=>$id_navigation], Response::HTTP_SEE_OTHER);
    }
  

    
    /**
     * @Route("/admin/navigation_liste/{id}/edit", name="navigation_liste_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NavigationListe $navigationListe, EntityManagerInterface $entityManager, navigationListeRepository $navigationListeRepository): Response
    {
       
        $form = $this->createForm(NavigationListeType::class, $navigationListe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           
            $id_navigation = $form->getData()->getNavigation()->getId();
            $entityManager->persist($navigationListe);
            $entityManager->flush();
            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );
            return $this->redirectToRoute('navigation_liste', ['id'=>$id_navigation], Response::HTTP_SEE_OTHER);
        }
            
        
        return $this->renderForm('admin/navigation_liste/edit.html.twig', [
            'navigationListe' => $navigationListe,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/navigation_liste/{id}", name="navigation_liste_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, navigationListe $navigationListe, EntityManagerInterface $entityManager): Response
    {
        $id_navigation = $navigationListe->getNavigation()->getId();
        $entityManager->remove($navigationListe);
        $entityManager->flush();
        $this->addFlash('success', 'navigation supprimé avec succés');
        return $this->redirectToRoute('navigation_liste', ['id'=>$id_navigation], Response::HTTP_SEE_OTHER);
    }
}
