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
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Method({"GET", "OPTIONS"})
     * Display all the notes present in the database with the possible actions (show, edit, del)
     */
    public function listNotes()
    {
        /*Pour que le navigateur puisse faire la requête, il faut ajouter le verbe OPTIONS qui
        est envoyé par défaut dans un premier temps.
        Cela est dû au Cross-Origin Resource Sharing (CORS)*/
        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("GET, OPTIONS");
        }

        //Retrieve the Notes from the database in an array()
        $data = $this->getDoctrine()->getRepository(Note::class)->findAll();
        //Serialize this data in a JSON format
        $data = $this->get('serializer')->serialize($data, 'json');
        //Return the JSON format to the client
        return JsonResponse::create($data, 200, ['Content-Type'=>'application/json']);
    }


    /**
     * @Route("/api/notes/{id}", name="api_note_show")
     * @Method({"GET", "OPTIONS"})
     */
    public function showNote(Note $note){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("GET, OPTIONS");
        }

        $data = $this->get('serializer')->serialize($note, 'json');

        return JsonResponse::create($data, 200, ['Content-Type'=>'application/json']);
    }


    /**
     * @Route("/api/notes", name="api_note_add")
     * @Method({"POST", "OPTIONS"})
     * @param Request $request
     */
    public function addNote(Request $request){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("POST, OPTIONS");
        }

        $note = new Note();
        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/api/notes/{id}", name="api_note_edit")
     * @Method({"PUT", "OPTIONS"})
     */
    public function editNote(Note $note, Request $request){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("PUT, OPTIONS");
        }

        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/api/notes/{id}", name="api_note_del")
     * @Method({"DELETE", "OPTIONS"})
     */
    public function deleteNote(Note $note){

        if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
        {
            $this->handleOptions("DELETE, OPTIONS");
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($note);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Note deleted']);
    }


    /**
     * Handle the process to create a new note OR edit an existing one
     */
    public function handleNote(Request $request, Note $note){

        $data = json_decode($request->getcontent(), true);

        $category = $this->getDoctrine()->getRepository(Category::class)
            ->find($data['category']);

        $note->setTitle($data['title']);
        $note->setContent($data['content']);
        $note->setCategory($category);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($note);
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
