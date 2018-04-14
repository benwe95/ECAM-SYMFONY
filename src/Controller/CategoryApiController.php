<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Entity\Note;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class CategoryApiController extends Controller
{

    /**
     * @Route("/api/categories", name="api_category_list")
     * @Method("GET")
     * @return JsonResponse
     */
    public function listCategories(){
        $data = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $data = $this->get('serializer')->serialize($data, 'json');

        return JsonResponse::create($data, 200, ['Content-Type'=>'application/json']);
    }


    /**
     * @Route("/api/categories/{id}", name="api_category_show")
     * @Method("GET")
     * @return JsonResponse
     */
    public function showCategory(Category $category){
        $data = $this->get('serializer')->serialize($category, 'json');

        return JsonResponse::create($data, 200, ['Content-Type'=>'application/json']);
    }


    /**
     * @Route("/api/categories", name="api_category_add")
     * @Method("POST")
     * @param Request $request
     * @return \App\Controller\CategoryController::handleCategory
     */
    public function addCategory(Request $request){
        $category = new Category();
        return $this->handleCategory($request, $category);
    }


    /**
     * @Route("/api/categories/{id}", name="api_category_edit")
     * @Method("PUT")
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
     * @Route("/api/categories/{id}", name="api_category_del")
     * @Method("DELETE")
     * @param Category $category
     * @param int $id
     * @return JsonResponse
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

        return new JsonResponse(['message' => 'Category deleted']);
    }


    /**
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function handleCategory(Request $request, Category $category){
        $data = json_decode($request->getContent(), true);

        $category->setWording($data['wording']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Changes saved']);
    }
}
