<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NewsType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class NewsType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
    * @ORM\OneToMany(targetEntity="News", mappedBy="NewsType")
    */
    private $News;
    
    public function __construct()
    {
        $this->News = new ArrayCollection();
    }

    public function getNews()
    {
        return $this->News;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return NewsType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    public function __toString(){
        
        return $this->type;
    }
    
    
   
}

