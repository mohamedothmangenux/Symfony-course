<?php

namespace AppBundle\Controller\admin;

use AppBundle\Form\BlogFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Post;
use AppBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("admin/blog/new", name="admin_blog_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(BlogFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setUpdated();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post created!');
            return $this->redirectToRoute('admin_blog_list');
        }
       
        return $this->render('blog/new.html.twig', [
            'blogform' => $form->createView()
        ]);
    }

    /**
     * Matches /blog exactly.
     *
     * @Route("admin/blog", name="admin_blog_list")
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
     * @Route("/adminblog/view/{id}", name="admin_post_view")
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
     * @Route("admin/blog/{id}/comments", name="get_comment_post")
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

    /**
     * @Route("/admin/post/{id}/edit", name="admin_post_edit")
     */
    public function editAction(Request $request, Post $post)
    {
        $form = $this->createForm(BlogFormType::class , $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setUpdated();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post Updated!');
            return $this->redirectToRoute('admin_blog_list');
        }

        return $this->render('blog/edit.html.twig', [
            'blogform' => $form->createView()
        ]);
    }
}
