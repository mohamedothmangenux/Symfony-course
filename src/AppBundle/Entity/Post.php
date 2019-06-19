<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=100)
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $description;
    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /** @ORM\Column(type="date") */
    private $postedAt;

    /** @ORM\Column(type="datetime") */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     * @ORM\OrderBy({"created_at"="DESC"})
     */
    private $comments;

    /**
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
    * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
    */
    private $category;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setPostedAt($postedAt)
    {
        $this->postedAt = $postedAt;
    }

    public function setUpdated()
    {
        // WILL be saved in the database
        $this->updated = new \DateTime("now");
    }

    /**
     * Get the value of comments.
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Get the value of postedAt
     */ 
    public function getPostedAt()
    {
        return $this->postedAt;
    }
}
