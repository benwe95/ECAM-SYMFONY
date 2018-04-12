<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 09.03.18
 * Time: 10:36
 */

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @Method({"GET"})
     */
    public function homepage()
    {
        return $this->render('note/homepage.html.twig');
    }

    /**
     * @Route("/notes/{slug}", name="note_show")
     */
    public function showNote($slug)
    {
        return $this->render('note/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/notes", name="list_notes_show")
     *
     * Display all the notes present in the database
     */
    public function showListNotes($slug)
    {
        /*$notes = ;
        return $this->render('note/listNotes.html.twig', [
            'notes' => $notes
        ]);*/
    }


}