<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoriesController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="categories", methods={"GET"})
     */
    public function index(Request $request,CategoriesRepository $categoriesRepository): Response
    {
        $typeCateg = $request->query->get('type');
        $categories = $categoriesRepository->findByType($typeCateg);
        return $this->render('admin/categories/index.html.twig', [
            'categories' => $categories,
            'type' => $typeCateg
        ]);
    }

    /**
     * @Route("/admin/categories/new", name="categories_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository): Response
    {
        $category = new Categories();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->getData()->getTitre();
            $is_existe_secteur = $categoriesRepository->findCategoryByTitre($titre);
            if($is_existe_secteur)
            {
                $this->addFlash('error', 'Un secteur est déjà existe avec ce titre');
                return $this->renderForm('admin/categories/new.html.twig', [
                    'form' => $form,
                  ]);
            }
            else{
                $type = $form->getData()->getType();
                $lastPosition = $categoriesRepository->findLastPosition($type);
                $nextPosition = $lastPosition[0]->getOrdre() + 1;
                $entityManager->persist($category);
                $category->setOrdre($nextPosition);
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('categories', ['type'=>$type], Response::HTTP_SEE_OTHER);
            }
            
        }
        return $this->renderForm('admin/categories/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/categories/reorder", name="categories_reorder", methods={"GET", "POST"})
    */
    public function reorder(Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository): Response
    {     
       $tableOrder = (array)$request->request->get('order');
       foreach ($tableOrder as $k=>$order)
       { 
          $category = $categoriesRepository->find($order);
          $position = $k + 1;
          $category->setOrdre($position);
          $entityManager->flush();
       }
        return $this->json([
            'success' => true,
            'data' => 'Position mis à jour.'
        ]); 
    }

    /**
     * @Route("/admin/categories/deleteSelected", name="categories_deleteSelected",  methods={"GET", "POST"})
     */
    public function deleteSelected(Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository): Response
    {
        $elementsSelected = $request->query->get('listSelected');
        $type = $request->query->get('type');
        $tabElements = explode(",", $elementsSelected);
        foreach ($tabElements as $element)
         {
            $category = $categoriesRepository->find($element);
            $entityManager->remove($category);  
         }
        $entityManager->flush();
        $this->addFlash('success', 'Mise à jour effectuée avec succés');
         return $this->redirectToRoute('categories', ['type'=>$type], Response::HTTP_SEE_OTHER);
    }
    

    /**
     * @Route("/admin/{id}/edit", name="categories_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categories $category, EntityManagerInterface $entityManager, CategoriesRepository $categoriesRepository): Response
    {
        $type_old = $category->getType();
        $form = $this->createForm(CategoriesType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titre = $form->getData()->getTitre();
            $id_category = $form->getData()->getId();
            $is_existe_secteur = $categoriesRepository->findCategoryByIdTitre($id_category, $titre);
            if($is_existe_secteur)
            {
                $this->addFlash('error', 'Un secteur est déjà existe avec ce titre');
                return $this->renderForm('admin/categories/new.html.twig', [
                    'form' => $form,
                  ]);
            }
            else{
                $type = $form->getData()->getType();
                // on fait la mise à jour de position si on change le type 
                if($type !== $type_old){
                    $lastPosition = $categoriesRepository->findLastPosition($type);
                    $nextPosition = $lastPosition[0]->getOrdre() + 1;
                    $category->setOrdre($nextPosition);
                }
                $entityManager->flush();
                $this->addFlash('success', 'Mise à jour effectuée avec succés');
                return $this->redirectToRoute('categories', ['type'=>$type], Response::HTTP_SEE_OTHER);
            } 
        }
        return $this->renderForm('admin/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/admin/categories/{id}", name="categories_delete", methods={"GET", "POST"})
     */
    public function delete(Request $request, Categories $category, EntityManagerInterface $entityManager): Response
    {
        $type = $category->getType();
        $entityManager->remove($category);
        $entityManager->flush();
        return $this->redirectToRoute('categories', ['type'=>$type], Response::HTTP_SEE_OTHER);
    }
    

   
}
