<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;

class BlogController extends Controller
{
    /**
     * @Route("/blog/new", name="blog_new")
     */
    public function newAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = new Post();
        $post->setTitle('Test Title Keyboard');
        $post->setDescription('Ergonomic and stylish!');
        $post->setstatus(1);
        $post->setpostedAt();
        $post->setupdated_at();
        $entityManager->persist($post);
        $entityManager->flush();

        return new Response('Saved new post with id '.$post->getId());
    }

    /**
     * Matches /blog exactly.
     *
     * @Route("/blog", name="blog_list")
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posts = $entityManager->getRepository('AppBundle\Entity\Post')
            ->findAll();

        return $this->render('blog/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/blog/view/{id}", name="post_view")
     */
    public function showAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository('AppBundle\Entity\Post')
            ->findOneBy(['id' => $id]);
        if (!$post) {
            throw $this->createNotFoundException('No Found Post');
        }

        return $this->render('blog/post.html.twig', [
            'post' => $post,
        ]);
    }
}
