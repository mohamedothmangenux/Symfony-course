<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;

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

        $comment = new Comment();
        $comment->setTitle('Test Title Keyboard'.rand(1, 99));
        $comment->setComment('Ergonomic and stylish!'.rand(1, 99));
        $comment->setEmail('test.'.rand(1, 99).'@gmail.com');
        $comment->setCreated_at();
        $comment->setPost($post);

        $entityManager->persist($post);
        $entityManager->persist($comment);
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
        $posts = $entityManager->getRepository('AppBundle:Post')
            ->findAllPublished();

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
        $post = $entityManager->getRepository('AppBundle:Post')
            ->findOneById($id);
        if (!$post) {
            throw $this->createNotFoundException('No Found Post');
        }
        $comments = $entityManager->getRepository('AppBundle:Comment')
            ->findAllRecentCommentsForPost($post);

        return $this->render('blog/post.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/blog/{id}/comments", name="get_comment_post")
     */
    public function getCommentsAction(Post $post)
    {
        foreach ($post->getComments() as $comment) {
            $comments[] = [
                'id' => $comment->getId(),
                'title' => $comment->getTitle(),
                'comment' => $comment->getComment(),
                'email' => $comment->getEmail(),
                'created_at' => $comment->getCreated_at(),
            ];
        }
        $data = [
            'comment' => $comments,
        ];

        return new JsonResponse($data);
    }
}
