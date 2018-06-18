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
use App\Form\NoteType;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{

    /**
     * Display all the notes present in the database with the possible actions (show, edit, del)
     * @Route("/notes", name="note_list")
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::render
     */
    public function listNotes()
    {
        $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();

        return $this->render('note/listNotes.html.twig',[
            'notes' => $notes
        ]);
    }


    /**
     * @Route("/notes/add", name="note_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \App\Controller\NoteController::handleNote
     */
    public function addNote(Request $request){
        $note = new Note();
        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/notes/show/{id}", name="note_show")
     * @param Note $note
     * @param int $id
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::render
     */
    public function showNote(Note $note, $id){

        /* Symfony provides services, such as the following one that throws an error 404 response
         * when the note doesn't exist
         */
        if (!$note) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);

    }


    /**
     * @Route("/notes/edit/{id}", name="note_edit")
     * @param Request $request
     * @param Note $note
     * @param int $id
     * @return \App\Controller\NoteController::handleNote
     */
    public function editNote(Request $request, Note $note, $id){

        if (!$note) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/notes/del/{id}", name="note_del")
     * @param Note $note
     * @param int $id
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::redirectToRoute
     */
    public function deleteNote(Note $note, $id){

        if (!$note) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($note);
        $entityManager->flush();

        return $this->redirectToRoute('note_list');
    }


    /**
     * Handle the process to create a new note OR edit an existing one
     * @param Request $request
     * @param Note $note
     * @return \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::render
     */
    public function handleNote(Request $request, Note $note)
    {

        /* Retrieves all the categories available to put them in the form */
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        /* Create a new instance of the form class NoteType and gives it the $note (if the method is called for an
         * 'edit' action then the fields of the form will be filled with the current information of the note)
         *  and the categories */
        $form = $this->createForm(NoteType::class, $note, array('categories' => $categories));

        /* Default method handleRequest inspects the given request and calls 'submit()' if the form was submitted. */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $note = $form->getData();

            if ($note->isValidContent()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($note);

                $entityManager->flush();

                /*$this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );*/

                /* Once the note is created or updated and the form is submitted then the application redirects to
                 * the list of notes */
                return $this->redirectToRoute('note_list');
            }

            return $this->render('note/new.html.twig', [
                'form' => $form->createView()
            ]);
        }

        /* Return the template of the form */
        return $this->render('note/new.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route ("/notes/search", name="note_search")
     * @Method ("POST")
     * @param String $tag
     * @return the view containing the notes with the researched tag
     */
    public function searchNotes(){

        $tag = $_POST["Search"];
        $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();
        $notes_with_tag = [];

        foreach ($notes as $note){
            if ($note->searchTag($tag)){
                array_push($notes_with_tag, $note);
            }
        }

        return $this->render('note/listNotes.html.twig',[
            'notes' => $notes_with_tag
        ]);
    }


}