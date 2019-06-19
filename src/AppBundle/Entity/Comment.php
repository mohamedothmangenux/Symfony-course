<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 */
class Comment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /** @ORM\Column(type="datetime") */
    private $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="Post",inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * Get the value of id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title.
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the value of comment.
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment.
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the value of email.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of created_at.
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at.
     */
    public function setCreated_at()
    {
        $this->created_at = new \DateTime('now');
    }

    /**
     * Get the value of post.
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set the value of post.
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }
}
