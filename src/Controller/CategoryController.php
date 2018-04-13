<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }


    /**
     * @Route("/categories", name="category_list")
     *
     */
    public function showCategories(){

    }


    /**
     * @Route("/add-category", name="category_add")
     * @param Request $request
     */
    public function addCategory(Request $request){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);

            $entityManager->flush();

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('category/category.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     *@Route("/edit-category/{id}", name="category_edit")
     */
    public function editCategory($id){

    }


    /*
     *@Route("/del-category/{id}", name="category_del")
     */
    public function deleteCategory($id){

    }
}
