<?php

namespace App\Entity;

use App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /***    Fields of the table    ***/

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;


    //Constructor to set default date
    public function __construct()
    {
        if ($this->getDate() == null) {
            $this->setDate(new \DateTime());
        }
    }


    /***   Getters and Setters   ***/

    public function getId(){
        return $this->id;
    }


    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title=$title;
        return $this;
    }


    public function getDate(){
        return $this->date;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateDate(){
        $this->setDateModified(new \DateTime());
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Note
     */
    public function setDate($dateModified){
        $this->date = $dateModified;
        return $this;
    }


    public function getContent(){
        return $this->content;
    }

    public function setContent($content){
        $this->content=$content;
        return $this;
    }


    public function getCategory(){
        return $this->category;
    }

    public function setCategory($category=null){
        $this->category = $category;
        return $this;
    }
}