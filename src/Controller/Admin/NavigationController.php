<?php

namespace App\Controller\Admin;

use App\Entity\Navigation;
use App\Form\NavigationMenuType;
use App\Repository\NavigationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Repository\NavigationListeRepository;


class NavigationController extends AbstractController
{
    /**
     * @Route("admin/navigation", name="navigation", methods={"GET"})
     */
    public function index(NavigationRepository $navigationRepository,NavigationListeRepository $navigationListeRepository): Response
    {
       
        return $this->render('admin/navigation/index.html.twig', [
            'ItemsNavigations' => $navigationRepository->findAll(),
            'navigation_liste' => $navigationListeRepository->findAll(),
     
        ]);
    }
     /**
     * @Route("admin/navigation/liste", name="navigation_items", methods={"GET", "POST"})
     */
    public function NavigationItems(Request $request,NavigationRepository $navigationRepository,NavigationListeRepository $navigationListeRepository): Response
    {
       
        $idNavigation= $request->query->get('id');
        $NameNavigation= $navigationRepository->findNameById($idNavigation);
        return $this->render('admin/navigation_liste/index.html.twig', [
            
             'navigation_liste' => $navigationListeRepository->findByNav($idNavigation),
             'ItemsNavigations' => $navigationRepository->findById($idNavigation),
             'navigation_name' =>$NameNavigation[0],
            
     
        ]);
    }
    //  /**
    //    * @Route("/admin/navigation/{id}", name="navigation_show", methods={"GET", "POST"})
    //   */
    //    public function show (Request $request,Navigation $navigation,NavigationRepository $navigationRepository): Response
    //    {
    //        return $this->render('admin/navigation/show.html.twig', [
    //            'navigation_liste' => $navigation,
    //            'navigation_liste' => $navigationRepository->findAll(),
    //        ]);
    //    }
    /**
     * @Route("admin/navigation/new", name="navigation_new", methods={"GET", "POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager, NavigationRepository $navigationRepository): Response
    {
        $navigation = new navigation();
        $form = $this->createForm(NavigationMenuType::class, $navigation); 
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
             $titre = $form->getData()->getTitre();
            
             
             $is_existe_secteur = $navigationRepository->findnavigationBytitre($titre);
             if($is_existe_secteur)
             {
                 $this->addFlash('error', 'Un secteur est déjà existe avec ce titre');
                 return $this->redirectToRoute('navigation_new', [], Response::HTTP_SEE_OTHER);
             }
             
            $entityManager->persist($navigation);
            $entityManager->flush();

            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );
            return $this->redirectToRoute('navigation', [], Response::HTTP_SEE_OTHER);
        }
        
       
        return $this->renderForm('admin/navigation/new.html.twig', [
            'ItemsNavigations' => $navigation,
            'form' => $form,
        
        ]);
    }

  
      /**
     * @Route("/admin/navigation/updateStatus", name="navigation_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager,NavigationRepository $navigationRepository): Response
    {     
        $idNavigation = (int)$request->request->get('idNavigation');
        $newActif = (int)$request->request->get('actif');
        $navigation = $navigationRepository->find($idNavigation);
        $navigation->setActif($newActif);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }

     /**
     * @Route("/admin/navigation/activeSelected", name="navigation_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager, NavigationRepository $navigationRepository): Response
    {
        
        $elementsSelected = $request->query->get('listSelected');
        $actif = (bool) $request->query->get('actif');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $navigation = $navigationRepository->find($element);
            $navigation->setActif($actif);
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('navigation', [], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/admin/navigation/deleteSelected", name="navigation_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, NavigationRepository $navigationRepository): Response
    {
      
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $navigation = $navigationRepository->find($element);
            $entityManager->remove($navigation);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('navigation', [], Response::HTTP_SEE_OTHER);
    }
   

    /**
     * @Route("/{id}/edit", name="navigation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Navigation $navigation,SluggerInterface $slugger, EntityManagerInterface $entityManager): Response
    {
       
       
        $form = $this->createForm(NavigationMenuType::class, $navigation); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           

           
            $entityManager->persist($navigation);
            $entityManager->flush();
            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );
            return $this->redirectToRoute('navigation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/navigation/edit.html.twig', [
            'ItemsNavigations' => $navigation,
            'form' => $form,
            
        ]);
    }

    /**
     * @Route("/admin/navigation/{id}", name="navigation_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Navigation $navigation, EntityManagerInterface $entityManager): Response
    {
       
        $entityManager->remove($navigation);
        $entityManager->flush();
        $this->addFlash('success', 'navigation supprimé avec succés');
        return $this->redirectToRoute('navigation', [], Response::HTTP_SEE_OTHER);
    }
}
