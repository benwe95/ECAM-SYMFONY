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
     * @Method({"GET", "OPTIONS"})
     * @return JsonResponse
     */
    public function listCategories(){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("GET, OPTIONS");
        }

        $data = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $data = $this->get('serializer')->serialize($data, 'json');

        return JsonResponse::create($data, 200, ['Content-Type'=>'application/json']);
    }


    /**
     * @Route("/api/categories/{id}", name="api_category_show")
     * @Method({"GET", "OPTIONS"})
     * @return JsonResponse
     */
    public function showCategory(Category $category){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("GET, OPTIONS");
        }

        $data = $this->get('serializer')->serialize($category, 'json');

        return JsonResponse::create($data, 200, ['Content-Type'=>'application/json']);
    }


    /**
     * @Route("/api/categories", name="api_category_add")
     * @Method({"POST", "OPTIONS"})
     * @param Request $request
     * @return \App\Controller\CategoryController::handleCategory
     */
    public function addCategory(Request $request){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("POST, OPTIONS");
        }

        $category = new Category();
        return $this->handleCategory($request, $category);
    }


    /**
     * @Route("/api/categories/{id}", name="api_category_edit")
     * @Method({"PUT", "OPTIONS"})
     * @param Category $category
     * @param int $id
     * @return \App\Controller\CategoryController::handleCategory
     */
    public function editCategory(Category $category, $id, Request $request){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("PUT, OPTIONS");
        }

        if (!$category) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->handleCategory($request, $category);
    }


    /**
     * @Route("/api/categories/{id}", name="api_category_del")
     * @Method({"DELETE", "OPTIONS"})
     * @param Category $category
     * @param int $id
     * @return JsonResponse
     */
    public function deleteCategory(Category $category, $id){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("DELETE, OPTIONS");
        }
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


    /*
     * Handle the automated OPTIONS request of the browser
     */
    public function handleOptions(string $verbs){
        $response = new Response();
        $response->headers->set('Content-Type', 'application/text');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set("Access-Control-Allow-Methods", $verbs);
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
        return $response;
    }
}
