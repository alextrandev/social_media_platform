<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Form\CommentType;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post', priority: 1)]
    public function index(MicroPostRepository $posts): Response
    {
        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAllWithComments(),
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(
        Request $req,
        EntityManagerInterface $em
    ): Response {

        $post = new MicroPost();
        $form = $this->createForm(MicroPostType::class, $post);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setCreated(new DateTime());
            $em->persist($post);
            $em->flush();

            // Add a toast popup
            $this->addFlash('success', 'Your post have been submitted');

            // Redirect to the list of posts
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render(
            'micro_post/add.html.twig',
            [
                'form' => $form,
            ]
        );
    }

    #[Route('micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(
        MicroPost $post,
        Request $req,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(MicroPostType::class, $post);
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em->persist($post);
            $em->flush();

            // Add a toast popup
            $this->addFlash('success', 'Your post have been updated');

            // Redirect to the list of posts
            return $this->redirectToRoute('app_micro_post');
        }

        return $this->render(
            'micro_post/edit.html.twig',
            [
                'form' => $form,
                'post' => $post,
            ]
        );
    }

    #[Route('micro-post/{post}/comment', name: 'app_micro_post_comment')]
    public function addComment(
        MicroPost $post,
        Request $req,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(CommentType::class, new Comment());
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();

            // Add a toast popup
            $this->addFlash('success', 'Your comment have been posted');

            // Redirect to the list of posts
            return $this->redirectToRoute(
                'app_micro_post_show',
                ['post' => $post->getId()]
            );
        }

        return $this->render(
            'micro_post/comment.html.twig',
            [
                'form' => $form,
                'post' => $post,
            ]
        );
    }
}
