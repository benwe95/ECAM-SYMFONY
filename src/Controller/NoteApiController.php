<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 09.03.18
 * Time: 10:36
 */

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Category;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * An API Rest to be used by other clients's applications.
 *
 * The purpose of this API is to perform changes in the database and to give back the data
 * in a particular format (here JSON) (depending on the client's request)
 * but it doesn't define the way they will be displayed (so there is no template).
 *
 * The application of the client will receive this data and choose the way it will display them.
 * Also the way the forms are made depends on the client. It only send the data to the API
 * to perform the changes in the database
 *
 * The requests use the HTTP protocol to define the action required
 *      GET    -> Read
 *      POST   -> Create
 *      PUT    -> Update
 *      DELETE -> Delete
 *
 * Only the GET action will imply a JsonResponse for the client.
 * The other actions make changes in the database but they only receive a simple response to precise if
 * it has been done with/without error.
 **/


class NoteApiController extends AbstractController
{
    /**
     * @Route("/api/notes", name="api_note_list")
     * @Method({"GET"})
     * Display all the notes present in the database with the possible actions (show, edit, del)
     */
    public function listNotes(){

        /* /!\ This is no more needed due to the CORS recipe added with composer /!\
         *
         * Pour que le navigateur puisse faire la requête, il faut ajouter le verbe OPTIONS qui
         * est envoyé par défaut dans un premier temps.
         * Cela est dû au Cross-Origin Resource Sharing (CORS)
         * if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
         * {
         *     $this->handleCrossOriginResponse("GET, OPTIONS");
         *   }
         */

        //Retrieve the Notes from the database in an array()
        $data = $this->getDoctrine()->getRepository(Note::class)->findAll();

        //Serialize this data in a JSON format
        $jsoncontent = $this->get('serializer')->serialize($data, 'json');

        $response = JsonResponse::fromJsonString($jsoncontent);

        //Return the JSON format to the client
        /*By default 'Content-type' is 'application/json'*/
        return $response;
    }


    /**
     * @Route("/api/notes/{id}", name="api_note_show")
     * @Method({"GET"})
     */
    public function showNote(Request $request, Note $note){

        $jsoncontent = $this->get('serializer')->serialize($note, 'json');

        $response = JsonResponse::fromJsonString($jsoncontent);

        return $response;
    }


    /**
     * @Route("/api/notes", name="api_note_add")
     * @Method({"POST"})
     * @param Request $request
     * @return Response
     */
    public function addNote(Request $request){

        $note = new Note();
        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/api/notes/{id}", name="api_note_edit")
     * @Method({"PUT"})
     */
    public function editNote(Note $note, Request $request){

        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/api/notes/{id}", name="api_note_del")
     * @Method({"DELETE"})
     */
    public function deleteNote(Note $note){

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($note);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Note deleted']);
    }


    /**
     * Handle the process to create a new note OR edit an existing one
     */
    public function handleNote(Request $request, Note $note){

        /* /!\ When testing with postman the content of the BODY sent must be in RAW form -> JSON not 'form-data' /!\ */
        $data = json_decode($request->getcontent(), true);

        $category = $this->getDoctrine()->getRepository(Category::class)
            ->find($data['category']);

        $note->setTitle($data['title']);
        $note->setContent($data['content']);
        $note->setCategory($category);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($note);
        $entityManager->flush();

        return new JsonResponse(['message'=> 'saved']);

    }


    /* /!\ This is no more needed due to the CORS recipe added with composer /!\
     *
     * Handle the automated OPTIONS request of the browser for Cross-Origin Resource Sharing
     *
     * public function handleCrossOriginResponse(string $verbs){
     *   $response = new Response();
     *   $response->headers->set('Content-Type', 'application/text');
     *   $response->headers->set('Access-Control-Allow-Origin', '*');
     *   $response->headers->set("Access-Control-Allow-Methods", $verbs);
     *   $response->headers->set('Access-Control-Allow-Headers', 'Content-Type',true);
     *   return $response;
     * }
     */
}
