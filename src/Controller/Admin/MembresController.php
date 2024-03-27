<?php

namespace App\Controller\Admin;

use App\Entity\Membres;
use App\Form\MembresType;
use App\Form\MembresEcolesType;
use App\Form\MembresSocietesType;
use App\Entity\Emailsubscription;
use Symfony\Component\Mime\Email;
use App\Repository\VillesRepository;
use App\Repository\MembresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class MembresController extends AbstractController
{
    /**
     * @Route("/admin/membres", name="membres", methods={"GET"})
     */
    public function index(Request $request, MembresRepository $membresRepository): Response
    {
       
        $typeMembre = $request->query->get('type');
        $membres = $membresRepository->findByType($typeMembre);// type = 1 stagiaire, type = 2 entreprise, type = 3 ecole
        return $this->render('admin/membres/index.html.twig', [
            'membres' => $membres,
            'typeMembre' => $typeMembre
        ]);
    }

    /**
     * @Route("/admin/membres/new", name="membres_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, MembresRepository $membresRepository,UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger): Response
    {
        $membre = new Membres();
        $typeMembre = $request->query->get('type');
        if($typeMembre == 1)
        {
            $form = $this->createForm(MembresType::class, $membre);
        }
        elseif($typeMembre == 2){
            $form = $this->createForm(MembresSocietesType::class, $membre);
        }
        else{
            $form = $this->createForm(MembresEcolesType::class, $membre); 
        }
        
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()->getEmail();
            $existe_membre =  $membresRepository->findMembreByEmail($email);
           
           if($existe_membre)
           {
              $this->addFlash('error', 'Un compte est déjà enregistré avec cet e-mail');
               return $this->renderForm('admin/membres/new.html.twig', [
                'form' => $form,
                'typeMembre' => $typeMembre
              ]);

           }
           else{
          
                $membre->setType($typeMembre);
                $date_add = new \DateTime ();
                $membre->setDateAdd($date_add);
                /*********** on crypte le pasword *************/
                $password = $form->getData()->getPassword();
                $hashedPassword = $passwordHasher->hashPassword(
                    $membre,
                    $password
                );
                $membre->setPassword($hashedPassword);
                if($request->request->get('photoMembre') !="" )
                {
                    $membre->setPhoto($request->request->get('photoMembre')); 
                }

                $entityManager->persist($membre);
                $entityManager->flush();
                /************insertion dans la table newslettre si le champ inscrit_nl = 1*************/
               if($membre->getInscritNl() == '1')
               {                
                   $emailsubscription = new Emailsubscription();
                   $emailsubscription->setIdMembre($membre);
                   $emailsubscription->setActif('1');
                   $emailsubscription->setEmail($membre->getEmail());
                   $emailsubscription->setNom($membre->getNom());
                   $emailsubscription->setPrenom($membre->getPrenom());
                   $emailsubscription->setType($membre->getType());
                   $date_inscrit = new \DateTime ();
                   $emailsubscription->setDateAdd($date_inscrit);
                   $entityManager->persist($emailsubscription);
                   $entityManager->flush();
               }

                /************ envoi mail de validation*****************/
                /*$email = (new Email())
                    ->from('saidasma179@gmail.com')
                    ->to('ghada@webspirit.tn')
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->html('<p>See Twig integration for better HTML integration!</p>');
                $mailer->send($email);*/
                    $this->addFlash('success', 'Mise à jour effectuée avec succés');
                    return $this->redirectToRoute('membres', ['type'=> $typeMembre], Response::HTTP_SEE_OTHER);
                }
       }
       elseif($form->isSubmitted() && !$form->isValid())
       {
       
          $this->addFlash('error', $form->getErrors());
          return $this->redirectToRoute('membres', ['type'=> $typeMembre], Response::HTTP_SEE_OTHER); 
       }
        return $this->renderForm('admin/membres/new.html.twig', [
            'membre' => $membre,
            'form' => $form,
            'typeMembre' => $typeMembre
        ]);
    }

     /**
     * @Route("/admin/membres/getVilles", name="membres_getVilles", methods={"GET", "POST"})
     */
    public function getVilles(Request $request, EntityManagerInterface $entityManager, VillesRepository $villesRepository)
    {

        $id_departement = (int)$request->request->get('idDepartement');
        $villes = $villesRepository->findVillesByDepartement($id_departement);
        return $this->json([
            'success' => true,
            'data' => $villes 
        ]); 
    }

    /**
     * @Route("/admin/membres/CropImage", name="membres_cropImage", methods={"GET", "POST"})
     */
    public function cropImage(Request $request, SluggerInterface $slugger)
    {

        if(isset($_POST["image"]))
        {
 
            $data = $_POST["image"];
            $image_array_1 = explode(";", $data);
            $image_array_2 = explode(",", $image_array_1[1]);
            $data = base64_decode($image_array_2[1]);
            $imagePath = 'uploads/photos-membres/' . time() . '.jpg';
            file_put_contents($imagePath, $data);
        }
         return $this->json([
             'success' => true,
             'path' => $imagePath ,
             'imageName'=> time() . '.jpg'
         ]); 
    }

    /**
     * @Route("/admin/membres/updateStatus", name="membres_updateStatus", methods={"GET", "POST"})
    */
    public function updateStatus(Request $request, EntityManagerInterface $entityManager, MembresRepository $membresRepository): Response
    {     
        $idMembre = (int)$request->request->get('idMembre');
        $newStatus = (int)$request->request->get('status');
        $membre = $membresRepository->find($idMembre);
        $membre->setStatus($newStatus);
        $entityManager->flush();
       
        return $this->json([
            'success' => true,
            'data' => 'Status mis à jour.'
        ]); 
    }

     /**
     * @Route("/admin/membres/activeSelected", name="membres_activeSelected",  methods={"GET", "POST"})
     */
    public function activeSelected(Request $request, EntityManagerInterface $entityManager, MembresRepository $membresRepository): Response
    {
        $type= $request->query->get('type');
        $elementsSelected = $request->query->get('listSelected');
        $status = (bool) $request->query->get('status');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ecole = $membresRepository->find($element);
            $ecole->setStatus($status);
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('membres', ['type'=>$type], Response::HTTP_SEE_OTHER);
    }

     /**
     * @Route("/admin/membres/deleteSelected", name="membres_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, MembresRepository $membresRepository): Response
    {
        $type= $request->query->get('type');
        $elementsSelected = $request->query->get('listSelected');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $ville = $membresRepository->find($element);
            $entityManager->remove($ville);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('membres', ['type'=>$type], Response::HTTP_SEE_OTHER);
    }

    // /**
    //  * @Route("/admin/membres/{id}", name="membres_show", methods={"GET"})
    //  */
    // public function show(Membres $membre): Response
    // {
    //     return $this->render('membres/show.html.twig', [
    //         'membre' => $membre,
    //     ]);
    // }

    /**
     * @Route("/admin/membres/{id}/edit", name="membres_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Membres $membre, EntityManagerInterface $entityManager, MembresRepository $membresRepository,UserPasswordHasherInterface $passwordHasher, SluggerInterface $slugger): Response
    {
        $typeMembre = $membre->getType('type');
        if($typeMembre == 1)
        {
            $form = $this->createForm(MembresType::class, $membre);
            $listData = 'membres';
        }
        elseif($typeMembre == 2){
            $form = $this->createForm(MembresSocietesType::class, $membre);
            $listData = 'membres_societes';
        }
        else{
            $form = $this->createForm(MembresEcolesType::class, $membre); 
            $listData = 'membres_ecoles';
        }
        
        $old_photo = $membre->getPhoto();
        if($old_photo !='')
        {
            $filename =  $this->getParameter('kernel.project_dir').'/public/uploads/photos-membres/'.$old_photo;
            $url_umage =  'uploads/photos-membres/'.$old_photo;
            $file_exists = file_exists($filename);
            $photo = array(
                'file_exists' => $file_exists,
                'filename' => $filename,
                'url_image' => $url_umage
            );
        }
        else{
            $photo = "";
        }
        $old_password = $form->getData()->getPassword() ;
        $data = $request->request->all();
        
        if($data)
        {
            $new_password = $data[$listData]['password'];
            if( $new_password == '')
            {
                $data[$listData]['password'] =  $old_password ;
                $request->request->replace($data);
            }
        }



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //on check si l'email est dèjà enregistré avec un autre membre
            $email = $form->getData()->getEmail();
            $existe_membre =  $membresRepository->findMembreByIDEmail($membre->getId(),$email);
           if($existe_membre)
           {
              $this->addFlash('error', 'Un compte est déjà enregistré avec cet e-mail');
               return $this->renderForm('admin/membres/new.html.twig', [
                'form' => $form,
                'typeMembre' => $membre->getType()
               ]);
           }
           else
           {
                // on check si le password est changé
                if($form->getData()->getPassword() != $old_password) 
                {
                    $password = $form->getData()->getPassword();
                    $hashedPassword = $passwordHasher->hashPassword(
                        $membre,
                        $password
                    );
                    $membre->setPassword($hashedPassword);
                    
                }
                if($request->request->get('photoMembre') !="" )
                {
                    $membre->setPhoto($request->request->get('photoMembre')); 
                }
                $entityManager->flush();
                 /************insertion dans la table newslettre si le champ inscrit_nl = 1*************/
               if($membre->getInscritNl() == '1')
               {                
                   $emailsubscription = new Emailsubscription();
                   $emailsubscription->setIdMembre($membre);
                   $emailsubscription->setActif('1');
                   $emailsubscription->setEmail($membre->getEmail());
                   $emailsubscription->setNom($membre->getNom());
                   $emailsubscription->setPrenom($membre->getPrenom());
                   $emailsubscription->setType($membre->getType());
                   $date_inscrit = new \DateTime ();
                   $emailsubscription->setDateAdd($date_inscrit);
                   $entityManager->persist($emailsubscription);
                   $entityManager->flush();
               }
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('membres', ['type'=>$membre->getType()], Response::HTTP_SEE_OTHER);
           }
        }
        return $this->renderForm('admin/membres/edit.html.twig', [
            'membre' => $membre,
            'form' => $form,
            'typeMembre' => $membre->getType(),
            'photo' => $photo
        ]);
    }

    /**
     * @Route("/admin/membres/{id}", name="membres_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Membres $membre, EntityManagerInterface $entityManager): Response
    {
       $type = $membre->getType();
        $entityManager->remove($membre);
        $entityManager->flush();
        $this->addFlash('success', 'Membre supprimé avec succés');
        return $this->redirectToRoute('membres', ['type'=>$type], Response::HTTP_SEE_OTHER);
    }
}
