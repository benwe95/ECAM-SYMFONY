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
     *
     */
    public function showCategories(){
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);

    }


    /**
     * @Route("/add-category", name="category_add")
     * @param Request $request
     */
    public function addCategory(Request $request){
        $category = new Category();
        return $this->handleCategory($request, $category);
    }


    /**
     * @Route("/show-category/{id}", name="category_show")
     */
    public function showCategory($id){
        $category = $this->getDoctrine()->getRepository()->fin($id);
        return $this->render('category/category.html.twig', [
            'category' => $category
        ]);
    }


    /**
     *@Route("/edit-category/{id}", name="category_edit")
     */
    public function editCategory($id, Request $request){
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->handleNote($request, $category);
    }


    /**
     *@Route("/del-category/{id}", name="category_del")
     */
    public function deleteCategory($id){
        $entityManager = $this->getDoctrine()->getManager();

        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

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
     *
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
