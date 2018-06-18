<?php

namespace App\Entity;

use App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;
use DOMDocument;

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
     * @ORM\Column(type="string")
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
        if ($this->getDate() == 0) {
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


    /* Return the content without the tag <tag> if there is any */
    public function getContent(){
        return str_replace(["<tag>", "</tag>"] , "", $this->content);
    }


    /* Utiliser un XML schema pour valider le contenu et vérifier la balise <tag></tag> */
    public function setContent($content){
        $this->content = $content;
        return $this->content;
    }

    public function isValidContent(){
        $dom = new DOMDocument();
        /* Rem:
         * - had to remove  <?xml version="1.0" encoding="UTF-8"?> because of
         * parser error : XML declaration allowed only at the start of the document
         * - had to put argument 'mixed true' to allow other type of content than <tag> element
         * - had to put minOccurs="0" in the sequence so it's allowed for the content to have 0 <tag> element
         */
        $xmlReference =
            "
            <xsd:schema xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">
            
            <xsd:element name=\"tag\" type=\"xsd:string\"/>
            
            <xsd:element name=\"content\">
              <xsd:complexType mixed=\"true\">
                <xsd:sequence minOccurs=\"0\">
                    <xsd:element ref=\"tag\"/>
                </xsd:sequence>
              </xsd:complexType>
            </xsd:element>
            
            </xsd:schema>
            ";

        try{
            // Chargement du contenu à vérifier
            /* Add <content> tag so it becomes an XML that validates the reference schema */
            $dom->loadXML("<content>" . $this->content . "</content>");
            /* Validation du contenu XML relativement au schéma XML défini dans la chaîne de caractères ci-dessus
             * True si valide False sinon
             * /!\ En cas d'échec des erreurs PHP de niveau Warning sont générées -> décrivent les dérives par rapport
             * au schéma de référence */
            return $dom->schemaValidateSource($xmlReference);
        }
        catch( \ErrorException $e)
        {
            echo "Content not valid" . $e->getMessage();
            return false;
        }
    }


    /* Search in the content the elements that are surrounded by the balise <tag></tag> and return them in an array */
    public function searchTag($tag){
        $dom = new DOMDocument();
        $dom->loadXML("<content>" . $this->content . "</content>");
        /* $dom->getElementsByTagName('tag') return an array containing NodeList Object that ar between <tag></tag> */
        $list_tag = $dom->getElementsByTagName('tag');
        foreach ($list_tag as $element){
            if ($element->nodeValue==$tag){
                return true;
            }
        }
        /*var_dump($list_tag['NodeValue']);
        if($list_tag['NodeValue']==$tag){
            return true;
        }*/
        return false;
    }


    public function getCategory(){
        return $this->category;
    }

    public function setCategory($category=null){
        $this->category = $category;
        return $this;
    }
}