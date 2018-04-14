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
     * @Route("/notes", name="note_list")
     *
     * Display all the notes present in the database with the possible actions (show, edit, del)
     */
    public function listNotes()
    {
        $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();

        return $this->render('note/listNotes.html.twig',[
            'notes' => $notes
        ]);
    }


    /**
     * @Route("/add-note", name="note_add")
     * @Method({"GET", "POST"})
     * @param Request $request
     */
    public function addNote(Request $request){
        $note = new Note();

        return $this->handleNote($request, $note);
    }


    /**
     * @Route("/show-note/{id}", name="note_show")
     */
    public function showNote($id){
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);

        if (!$note) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->render('note/show.html.twig', [
            'note' => $note
        ]);

    }


    /**
     *@Route("/edit-note/{id}", name="note_edit")
     */
    public function editNote($id, Request $request){
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);

        if (!$note) {
            throw $this->createNotFoundException(
                'No note found for id ' . $id
            );
        }

        return $this->handleNote($request, $note);
    }


    /**
     *@Route("/del-note/{id}", name="note_del")
     */
    public function deleteNote($id){
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);

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
     */
    public function handleNote(Request $request, Note $note){

        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        $form = $this->createForm(NoteType::class, $note, array('categories'=>$categories));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $note = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($note);

            $entityManager->flush();

            return $this->redirectToRoute('note_list');
        }

        return $this->render('note/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

}