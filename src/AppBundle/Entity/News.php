<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class News
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
     * @ORM\Column(name="news_title", type="string", length=255)
     */
    private $newsTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="news_content", type="text")
     */
    private $newsContent;

    /**
     * @var string
     *
     * @ORM\Column(name="createUser", type="text")
     */
    private $createUser;

    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createtime", type="datetime")
     */
    private $createtime;

    /**
     * @var string
     *
     * @ORM\Column(name="images", type="text")
     */
    private $images;
    
    
     /**
     * @ORM\ManyToOne(targetEntity="NewsType", inversedBy="News")
     */
    private $news_type;

    
    public function setNewsType(NewsType $type)
    {
        $this->news_type = $type;
    }

    public function getNewsType()
    {
        return $this->news_type;
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
     * Set newsTitle
     *
     * @param string $newsTitle
     *
     * @return News
     */
    public function setNewsTitle($newsTitle)
    {
        $this->newsTitle = $newsTitle;

        return $this;
    }

    /**
     * Get newsTitle
     *
     * @return string
     */
    public function getNewsTitle()
    {
        return $this->newsTitle;
    }

    /**
     * Set newsContent
     *
     * @param string $newsContent
     *
     * @return News
     */
    public function setNewsContent($newsContent)
    {
        $this->newsContent = $newsContent;

        return $this;
    }

    /**
     * Get newsContent
     *
     * @return string
     */
    public function getNewsContent()
    {
        return $this->newsContent;
    }

    /**
     * Set createUser
     *
     * @param string $createUser
     *
     * @return News
     */
    public function setCreateUser($createUser)
    {
        $this->createUser = $createUser;

        return $this;
    }

    /**
     * Get createUser
     *
     * @return string
     */
    public function getCreateUser()
    {
        return $this->createUser;
    }


    /**
     * Set createtime
     *
     * @param \DateTime $createtime
     *
     * @return News
     */
    public function setCreatetime($createtime)
    {
        if(empty($this->createtime)){
            $this->createtime = $createtime;
        }
        return $this;
    }

    /**
     * Get createtime
     *
     * @return \DateTime
     */
    public function getCreatetime()
    {
        return $this->createtime;
    }

    /**
     * Set images
     *
     * @param string $images
     *
     * @return News
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return string
     */
    public function getImages()
    {
        return $this->images;
    }
    
    public function __toString() {
        return $this->getNewsTitle();
    }
}

