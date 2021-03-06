<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\Note;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategoryController extends Controller
{

    /**
     * @Route("/categories", name="category_list")
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::render
     */
    public function showCategories(){
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);

    }


    /**
     * @Route("/categories/add", name="category_add")
     * @param Request $request
     * @return \App\Controller\CategoryController::handleCategory
     */
    public function addCategory(Request $request){
        $category = new Category();
        return $this->handleCategory($request, $category);
    }


    /**
     * @Route("/categories/edit/{id}", name="category_edit")
     * @param Category $category
     * @param int $id
     * @return \App\Controller\CategoryController::handleCategory
     */
    public function editCategory(Category $category, $id, Request $request){
        if (!$category) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->handleCategory($request, $category);
    }


    /**
     * @Route("/categories/del/{id}", name="category_del")
     * @param Category $category
     * @param int $id
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::redirectToRoute
     */
    public function deleteCategory(Category $category, $id){
        $entityManager = $this->getDoctrine()->getManager();

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id ' . $id
            );
        }

        //Retrieve the notes which correspond to this category and set their value to 'uncategorized'
        $notes = $this->getDoctrine()->getRepository(Note::class)->findBy([
            'category' => $id
        ]);

        foreach ($notes as $note){
            $note->setCategory(null);
            $entityManager->flush();
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('category_list');
    }


    /**
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::render
     */
    public function handleCategory(Request $request, Category $category){

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);

            $entityManager->flush();

            return $this->redirectToRoute('category_list');
        }

        return $this->render('category/category.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
