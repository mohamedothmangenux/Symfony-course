<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;


class BlogController extends Controller
{
     /**
     * Matches /blog exactly
     *
     * @Route("/blog/new", name="blog_new")
     */
    public function newAction()
    {
       $entityManager = $this->getDoctrine()->getManager();
        $post = New Post();
        $post->setTitle('Test Title Keyboard');
        $post->setDescription('Ergonomic and stylish!');
        $entityManager->persist($post);
        $entityManager->flush();

        return new Response('Saved new post with id '.$post->getId());
    }
    /**
     * Matches /blog exactly
     *
     * @Route("/blog", name="blog_list")
     */
    public function listAction()
    {
        
       return new Response("test");
       
    }

}