<?php

namespace App\Controller\Admin;

use App\Entity\Emailsubscription;
use App\Form\EmailsubscriptionType;
use App\Repository\EmailsubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EmailsubscriptionController extends AbstractController
{
    /**
     * @Route("/admin/emailsubscription", name="emailsubscription", methods={"GET"})
     */
    public function index(EmailsubscriptionRepository $EmailsubscriptionRepository): Response
    {
        return $this->render('admin/emailsubscription/index.html.twig', [
            'emailsubscription' => $EmailsubscriptionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/emailsubscription/new", name="emailsubscription_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,EmailsubscriptionRepository $EmailsubscriptionRepository): Response
    {
        $emailsubscription = new Emailsubscription();
        $form = $this->createForm(EmailsubscriptionType::class, $emailsubscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()->getEmail();
            $emailsubscription->setDateAdd(new \DateTime('now'));
            $is_existe_Emailsubscription = $EmailsubscriptionRepository->findEmailsubscriptionByEmail($email);
            if($is_existe_Emailsubscription)
            {
                $this->addFlash('error', 'ce compte est déjà existe');
                return $this->renderForm('admin/emailsubscription/new.html.twig', [
                    'form' => $form,
                  ]);
            }
            else{
                $entityManager->persist($emailsubscription);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('emailsubscription', [], Response::HTTP_SEE_OTHER);
            } 
        }
        return $this->renderForm('admin/emailsubscription/new.html.twig', [
            'emailsubscription' => $emailsubscription,
            'form' => $form,
        ]);
    }


   
     /**
     * @Route("/admin/emailsubscription/updateStatus", name="emailsubscription_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager, EmailsubscriptionRepository $EmailsubscriptionRepository): Response
    {     
        $idEmailsubscription = (int)$request->request->get('idEmailsubscription');
        $newActif = (int)$request->request->get('actif');
        $emailsubscription = $EmailsubscriptionRepository->find($idEmailsubscription);
        $emailsubscription->setActif($newActif);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }

     /**
     * @Route("/admin/emailsubscription/activeSelected", name="emailsubscription_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager,  EmailsubscriptionRepository $EmailsubscriptionRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $actif = (bool) $request->query->get('actif');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $emailsubscription = $EmailsubscriptionRepository->find($element);
            $emailsubscription->setActif($actif);
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('emailsubscription', [], Response::HTTP_SEE_OTHER);
    }
     /**
     * @Route("/admin/emailsubscription/deleteSelected", name="emailsubscription_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, EmailsubscriptionRepository $EmailsubscriptionRepository): Response
    {
        $elementsSelected = $request->query->get('Emailsubscription');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $emailsubscription = $EmailsubscriptionRepository->find($element);
            $entityManager->remove( $emailsubscription);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('emailsubscription', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/admin/emailsubscription/{id}/edit", name="emailsubscription_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Emailsubscription $emailsubscription, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmailsubscriptionType::class, $emailsubscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash(
                'Succes',
                'Vos modifications ont été enregistrées avec succes !'
            );

            return $this->redirectToRoute('emailsubscription', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/emailsubscription/edit.html.twig', [
            'emailsubscription' => $emailsubscription,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/admin/emailsubscription/{id}", name="emailsubscription_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Emailsubscription $emailsubscription, EntityManagerInterface $entityManager ): Response
    {
     
            $entityManager->remove($emailsubscription);
            $entityManager->flush();
             $this->addFlash(
                'Succes',
                'Votre suppression a été enregistrée avec succès !'
                );
            
    

        return $this->redirectToRoute('emailsubscription', [], Response::HTTP_SEE_OTHER);

    }
}
