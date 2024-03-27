<?php

namespace App\Controller\Admin;

use App\Entity\ListeOffres;
use App\Form\ListeOffresType;
use App\Repository\ListeOffresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;



class ListeOffresController extends AbstractController
{   private $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("admin/liste_offres", name="liste_offres", methods={"GET"})
     */
    public function index(ListeOffresRepository $listeOffresRepository): Response
    {
        return $this->render('admin/liste_offres/index.html.twig', [
            'liste_offres' => $listeOffresRepository->findAll(),
        ]);
    }
    /**
     * @Route("admin/liste_offres/new", name="liste_offres_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager , ListeOffresRepository $listeOffresRepository): Response
    {
        $liste_offres = new ListeOffres();
        $form = $this->createForm(ListeOffresType::class, $liste_offres);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $liste_offres->setDateInscri(new \DateTime('now'));
            $titre = $form->getData()->getTitre();
            $is_existe_secteur = $listeOffresRepository->findListeBytitre($titre);
            if($is_existe_secteur)
            {
                $this->addFlash('error', 'Un secteur est déjà existe avec ce titre');
                return $this->redirectToRoute('liste_offres_new', [], Response::HTTP_SEE_OTHER);
            }
            $entityManager->persist($liste_offres);
            $entityManager->flush();
            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );
            return $this->redirectToRoute('liste_offres', [], Response::HTTP_SEE_OTHER);
        }
        
       
        return $this->renderForm('admin/liste_offres/new.html.twig', [
            'liste_offres' => $liste_offres,
            'form' => $form,
            'page_name' => 'page-liste_offres',
        ]);
    }


    // /**
    //  * @Route("admin/liste_offres/{id}", name="app_liste_offres_show", methods={"GET"})
    //  */
    // public function show(ListeOffres $listeOffre): Response
    // {
    //     return $this->render('liste_offres/show.html.twig', [
    //         'liste_offre' => $listeOffre,
    //     ]);
    // }
     /**
     * @Route("/admin/liste_offres/updateStatus", name="liste_offres_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager, ListeOffresRepository $listeOffresRepository): Response
    {     
        $idListeOffres = (int)$request->request->get('idListe_offres');
        $newActif = (int)$request->request->get('actif');
        $listeOffres = $listeOffresRepository->find($idListeOffres);
        $listeOffres->setActif($newActif);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }


     /**
     * @Route("/admin/liste_offres/activeSelected", name="liste_offres_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager,  ListeOffresRepository $listeOffresRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $actif = (bool) $request->query->get('actif');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ListeOffres = $listeOffresRepository->find($element);
            $ListeOffres->setActif($actif);
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('liste_offres', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/admin/liste_offres/deleteSelected", name="liste_offres_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, ListeOffresRepository $listeOffresRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ListeOffres= $listeOffresRepository->find($element);
            $entityManager->remove($ListeOffres);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('liste_offres', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("admin/liste_offres/{id}/edit", name="liste_offres_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ListeOffres $liste_offres, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListeOffresType::class, $liste_offres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );

            return $this->redirectToRoute('liste_offres', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/liste_offres/edit.html.twig', [
            'liste_offres' => $liste_offres,
            'form' => $form,
        ]);
    }
    /**
     * @Route("admin/liste_offres/{id}", name="liste_offres_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, ListeOffres $liste_offres, EntityManagerInterface $entityManager ): Response
    {
     
            $entityManager->remove($liste_offres);
            $entityManager->flush();
             $this->addFlash(
                'Succes',
                'Votre suppression a été enregistrée avec succès !'
                );
            
    

        return $this->redirectToRoute('liste_offres', [], Response::HTTP_SEE_OTHER);

    }
}